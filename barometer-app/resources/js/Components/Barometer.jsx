import React from "react";
import GaugeComponent from "react-gauge-component";
import { defaultTickLabels } from "react-gauge-component/dist/lib/GaugeComponent/types/Tick";

const Barometer = () => {
    return (
        <GaugeComponent
            type="radial"
            id="barometer"
            minValue={950}
            maxValue={1050}
            arc={{
                cornerRadius: 7,
                gradient: true,
                padding: 0.05,
                width: 0.2,
                colorArray: [
                    "#42A5F5",
                    "#66BB6A",
                    "#FFEB3B",
                    "#FF7043",
                    "#EA4228",
                ],
                subArcs: [
                    { limit: 960, showTick: true },
                    { limit: 970, showTick: true },
                    { limit: 980, showTick: true },
                    { limit: 990, showTick: true },
                    { limit: 1000, showTick: true },
                    { limit: 1010, showTick: true },
                    { limit: 1020, showTick: true },
                    { limit: 1030, showTick: true },
                    { limit: 1040, showTick: true },
                    {},
                ],
            }}
            value={980}
            pointer={{ 
                type: "needle", 
                elastic: false,

            }}
            labels={{
                valueLabel: {
                    display: true,
                },
                tickLabels: {
                    defaultTickValueConfig:{
                        style: {
                            fontSize: "12px"
                        }
                    }
                }
            }}
        />
    );
};

export default Barometer;
