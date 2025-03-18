import { BellIcon } from "@chakra-ui/icons";
import {
    Button,
    FormControl,
    FormLabel,
    Input,
    Modal,
    ModalBody,
    ModalCloseButton,
    ModalContent,
    ModalFooter,
    ModalHeader,
    ModalOverlay,
    useDisclosure,
} from "@chakra-ui/react";
import axios from "axios";
import React, { useEffect, useState } from "react";

const Dashboard = () => {
    const { isOpen, onOpen, onClose } = useDisclosure();
    const finalRef = React.useRef(null);

    //state manage;
    const [notice, setNotice] = useState({ notice: "" });
    const [allNotice, setAllNotice] = useState([]);

    //get all notice from db;
    const getNotice = async () => {
        try {
            const response = await axios.get(
                "http://127.0.0.1:8000/api/notice"
            );
            if (response?.status === 200) {
                setAllNotice(response?.data?.notices);
            }
        } catch (error) {
            console.error("Error fetching notices", error);
        }
    };

    //onchange notice;
    const handleNoticeChange = (event) => {
        setNotice({
            ...notice,
            image : event?.target?.files?.[0],
            [event.target.name]: event.target.value,

        });
    };

    //Notice create function;
    const handleNotice = async (event) => {
        event.preventDefault();
        try {
            const response = await axios.post(
                "http://127.0.0.1:8000/api/create-notice",
                notice,{
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                }
            );
            console.log( response?.data.notice );

            if (response?.status === 201) {
                setAllNotice((prevNtc) => [...prevNtc, response?.data?.notice]);
            }

            setNotice({ notice: ""});

        } catch (error) {
            console.log("notice create failed");
        }
    };

    //Get all notice;
    useEffect(() => {
        getNotice();
    }, []);

    return (
        <div style={{ width: "40%", margin: "auto", marginTop: "30px" }}>
            <h2
                style={{
                    fontSize: "20px",
                    fontWeight: "bold",
                    textAlign: "center",
                }}
            >
                Welcome to Dashboard
            </h2>
            <Button mt={4} mb={10} onClick={onOpen}>
                <BellIcon />
                <p
                    style={{
                        color: "white",
                        backgroundColor: "red",
                        borderRadius: "50%",
                        width: "20px",
                        height: "20px",
                        paddingTop: "2px",
                    }}
                >
                    {allNotice?.length}
                </p>
            </Button>
            <div>
                <Modal
                    finalFocusRef={finalRef}
                    isOpen={isOpen}
                    onClose={onClose}
                >
                    <ModalOverlay />
                    <ModalContent>
                        <ModalHeader>All Notice from admin</ModalHeader>
                        <ModalCloseButton />
                        <ModalBody>
                            {allNotice?.length > 0
                                ? allNotice?.map((notice, index) => (
                                      <h2 key={index}>{notice.notice}</h2>
                                  ))
                                : "no notice"}
                        </ModalBody>

                        <ModalFooter>
                            <Button colorScheme="blue" mr={3} onClick={onClose}>
                                Close
                            </Button>
                        </ModalFooter>
                    </ModalContent>
                </Modal>
            </div>
            <form onSubmit={handleNotice}>
                <FormControl>
                    <FormLabel>Create Notice</FormLabel>
                    <Input
                        type="text"
                        name="notice"
                        value={notice.notice}
                        onChange={handleNoticeChange}
                    />
                </FormControl>
                <FormControl>
                    <FormLabel>Upload File</FormLabel>
                    <Input
                        type="file"
                        name="file"
                        accept="image/*"
                        onChange={handleNoticeChange}
                    />
                </FormControl>
                <Button colorScheme="blue" type="submit" marginTop={5}>
                    Button
                </Button>
            </form>
        </div>
    );
};

export default Dashboard;
