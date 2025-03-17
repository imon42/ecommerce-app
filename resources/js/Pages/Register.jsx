import { Button, FormControl, FormLabel, Input } from "@chakra-ui/react";
import { router } from "@inertiajs/react";
import axios from "axios";
import React, { useState } from "react";

const Register = () => {
    const [register, setRegister] = useState({
        name: "",
        email: "",
        password: "",
    });

    const handleChange = (event) => {
        setRegister({
            ...register,
            [event.target.name]: event.target.value,
        });
    };

    const handleSubmit = async (event) => {
        event.preventDefault();
        try {
            await axios.post("http://127.0.0.1:8000/api/register", register);
            console.log("Registration success");
            router.visit("/login");
        } catch (error) {
            console.log("Registration failed!");
        }
    };

    return (
        <div style={{ width: "40%", margin: "auto", marginTop: "30px" }}>
            <form onSubmit={handleSubmit}>
                <FormControl>
                    <FormLabel>Name</FormLabel>
                    <Input
                        type="text"
                        name="name"
                        value={register.name}
                        onChange={handleChange}
                    />
                </FormControl>
                <FormControl>
                    <FormLabel>Email address</FormLabel>
                    <Input
                        type="email"
                        name="email"
                        value={register.email}
                        onChange={handleChange}
                    />
                </FormControl>
                <FormControl>
                    <FormLabel>Password</FormLabel>
                    <Input
                        type="password"
                        name="password"
                        value={register.password}
                        onChange={handleChange}
                    />
                </FormControl>
                <Button colorScheme="blue" type="submit" marginTop={5}>
                    Button
                </Button>
            </form>
        </div>
    );
};

export default Register;
