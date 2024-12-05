import * as React from "react";
import ToggleButton from "@mui/material/ToggleButton";
import ToggleButtonGroup from "@mui/material/ToggleButtonGroup";

export default function LocationToggleButton({ locationName, onLocationChange }) {
    const handleChange = (event, newLocation) => {
        if (newLocation !== null) {
            onLocationChange(newLocation);
        }
    };

    return (
        <ToggleButtonGroup
            color="primary"
            value={locationName}
            exclusive
            onChange={handleChange}
            aria-label="Location"
        >
            <ToggleButton value="Nida">Nida</ToggleButton>
            <ToggleButton value="Vilnius">Vilnius</ToggleButton>
        </ToggleButtonGroup>
    );
}
