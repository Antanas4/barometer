import React, { useEffect, useState } from "react";
import Barometer from "@/Components/Barometer";

const Home = () => {
    const [pressure, setPressure] = useState(null);
    const locationName = "Nida";

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
    }, [locationName]);

    return (
        <div className="home-container">
            <div className="barometer-container">
                {pressure !== null ? (
                    <Barometer pressure={pressure} />
                ) : (
                    <p>Loading pressure data...</p>
                )}
            </div>
        </div>
    );
};

export default Home;
