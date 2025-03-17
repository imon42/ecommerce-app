
import { Link } from "@inertiajs/react";
import React from "react";

const Home = () => {
    return (
        <div style={{ width: "40%", margin: "auto", marginTop: "30px" }}>
            <h2
                style={{
                    fontSize: "20px",
                    fontWeight: "bold",
                    textAlign: "center",
                }}
            >
                Welcome to the home page
            </h2>
            <div
                style={{
                    display: "flex",
                    justifyContent: "center",
                    gap: "20px",
                    marginTop: "20px",
                    fontWeight: "bold",
                    fontSize: "20px",
                }}
            >
                <p><Link href="/register">Register</Link></p>
                <p><Link href="/login">Login</Link></p>
            </div>
        </div>
    );
};

export default Home;
