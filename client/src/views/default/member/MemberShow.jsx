import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import { useStateContext } from "../../../contexts/ContextProvider";
import Title from "../../../components/widgets/Title";
import maleUser from "../../../assets/maleUser.svg";
import profileUser from "../../../assets/profileUser.svg";

const MemberShow = ({ title }) => {
    const { darkMode, token, toggleDarkMode } = useStateContext();
    const navigate = useNavigate();

    if (!token) {
        navigate("/login");
        return null;
    }

    return (
        <div className="grid grid-cols-1 font-sans my-5 md:mx-6 lg:mx-8 space-y-5 md:space-y-0">
            <div className="mx-5 md:mx-12">
                <Title title={title} darkMode={darkMode} />
            </div>
            <div className="grid md:grid-cols-10 gap-6 mx-5 md:mx-16">
                <div className="md:col-span-4 py-5 bg-white shadow-md border rounded-md text-center">
                    <img src={profileUser} alt="avatar" className="h-48 w-48 mx-auto" />
                    <h3 className="text-3xl font-bold text-[#142D55]">Alvin Azalia Malik</h3>
                    <p className="text-lg">Backend Developer</p>
                    <div className="text-left mx-8 bg-[#EBEBEB] rounded-xl p-2 mt-6">
                        <h3 className="text-sm font-semibold text-[#142D55]">Email</h3>
                        <p className="text-xs">alvinmalik@gmail.com</p>
                    </div>
                    <div className="text-left mx-8 bg-[#EBEBEB] rounded-xl p-2 mt-3">
                        <h3 className="text-sm font-semibold text-[#142D55]">Address</h3>
                        <p className="text-xs">Serang, Indonesia</p>
                    </div>
                </div>
                <div className="md:col-span-6">
                    <div className="grid md:grid-cols-2 gap-6">
                        <div className="md:col-span-1 bg-white p-8 shadow-md border rounded-md py-8">
                            <h3 className="text-2xl font-bold mb-3 text-[#142D55]">Social Media</h3>
                            <div className="text-left  bg-[#EBEBEB] rounded-xl p-2 mt-3">
                                <h3 className="text-sm font-semibold text-[#142D55]">Github</h3>
                                <p className="text-xs">https://github.com/Avzls</p>
                            </div>
                            <div className="text-left  bg-[#EBEBEB] rounded-xl p-2 mt-3">
                                <h3 className="text-sm font-semibold text-[#142D55]">Linkedin</h3>
                                <p className="text-xs">https://linkedin.com/Avzls</p>
                            </div>
                            <div className="text-left  bg-[#EBEBEB] rounded-xl p-2 mt-3">
                                <h3 className="text-sm font-semibold text-[#142D55]">Instagram</h3>
                                <p className="text-xs">https://Instagram.com/Avzls</p>
                            </div>
                        </div>
                        <div className="md:col-span-1 bg-white p-8 shadow-md border rounded-md py-8">
                            <h3 className="text-2xl font-bold mb-3 text-[#142D55]">Pendidikan</h3>
                            <div className="text-left  bg-[#EBEBEB] rounded-xl p-2 mt-3">
                                <h3 className="text-sm font-semibold text-[#142D55]">Sarjana</h3>
                                <p className="text-xs">Universitas Telkom</p>
                            </div>
                            <h3 className="text-2xl font-bold mt-8 mb-3 text-[#142D55]">Pekerjaan</h3>
                            <div className="text-left  bg-[#EBEBEB] rounded-xl p-2 mt-3">
                                <h3 className="text-sm font-semibold text-[#142D55]">Fullstack Developer</h3>
                                <p className="text-xs">PT Bank Central Asia</p>
                            </div>
                        </div>
                    </div>
                    <div className="md:col-span-1 bg-white mt-5 px-8 shadow-md border rounded-md">
                        <h3 className="text-2xl font-bold mt-8 mb-3 text-[#142D55]">Portofolio</h3>
                        <div className="flex items-center bg-[#EBEBEB] p-2 rounded-xl my-3">
                            <div className="mx-5">
                                <img src={maleUser} alt="avatar" className="h-24 w-24 rounded-full" />
                            </div>
                            <div>
                                <h3 className="text-sm font-semibold text-[#142D55]">Sistem Absensi</h3>
                                <p className="text-xs">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut magna ac turpis lobortis consectetur.
                                    Integer varius felis sed nunc ultrices suscipit. Sed consequat efficitur orci non ultricies. Cras viverra </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    );
};

export default MemberShow;
