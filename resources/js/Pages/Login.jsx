import { Button, FormControl, FormLabel, Input } from "@chakra-ui/react";
import { router } from "@inertiajs/react";
import axios from "axios";
import React, { useState } from "react";
import { toast } from "react-toastify";

const Login = () => {
    const [loginData, setLoginData] = useState({
        email: "",
        password: "",
    });

    const handleLoginChange = (event) => {
        setLoginData({
            ...loginData,
            [event.target.name]: event.target.value,
        });
    };

    const handleLoginSubmit = async (event) => {
        event.preventDefault();
        try {
            await axios.post("http://127.0.0.1:8000/api/login", loginData);
            router.visit("/dashboard");
        } catch (error) {
            toast.error("login failed");
        }
    };

    return (
        <div style={{ width: "40%", margin: "auto", marginTop: "30px" }}>
            <form onSubmit={handleLoginSubmit}>
                <FormControl>
                    <FormLabel>Email address</FormLabel>
                    <Input
                        type="email"
                        name="email"
                        value={loginData.email}
                        onChange={handleLoginChange}
                    />
                </FormControl>
                <FormControl>
                    <FormLabel>Password</FormLabel>
                    <Input
                        type="password"
                        name="password"
                        value={loginData.password}
                        onChange={handleLoginChange}
                    />
                </FormControl>
                <Button colorScheme="blue" type="submit" marginTop={5}>
                    Button
                </Button>
            </form>
        </div>
    );
};

export default Login;
