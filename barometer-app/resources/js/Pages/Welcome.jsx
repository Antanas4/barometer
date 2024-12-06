import React, { useEffect, useState } from "react";
import Barometer from "@/Components/Barometer";
import LocationToggleButton from "@/Components/LocationToggleButton";

const Home = () => {
    const [pressure, setPressure] = useState(null);
    const [locationName, setLocationName] = useState("Vilnius");

    const handleLocationChange = (newLocation) => {
        setLocationName(newLocation);
    };

    const determineWeatherCondition = (pressure) => {
        if (pressure < 980) return "Stormy";
        if (pressure >= 980 && pressure < 1000) return "Rain";
        if (pressure >= 1000 && pressure < 1010) return "Change";
        if (pressure >= 1010 && pressure < 1020) return "Fair";
        if (pressure >= 1020) return "Very Dry";
        return "Unknown";
    };

    useEffect(() => {
        const fetchWeatherData = async () => {
            try {
                const response = await fetch(`/${locationName}`);
                const data = await response.json();

                if (data.success) {
                    setPressure(data.data.pressure);
                } else {
                    console.error("Failed to fetch weather data");
                }
            } catch (error) {
                console.error("Error fetching weather data:", error);
            }
        };
        fetchWeatherData();
        const intervalId = setInterval(fetchWeatherData, 60 * 60 * 1000); // 60 minutes
        return () => clearInterval(intervalId);
    }, [locationName]);

    return (
        <div className="home-container">
            <div className="barometer-container">
                {pressure !== null ? (
                    <>
                        <Barometer pressure={pressure} />
                    </>
                ) : (
                    <p>Loading pressure data...</p>
                )}
            </div>
            <div className="location-btn-group">
                <LocationToggleButton
                    locationName={locationName}
                    onLocationChange={handleLocationChange}
                />
            </div>
        </div>
    );
};

export default Home;
