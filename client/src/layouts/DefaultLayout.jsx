import React, { useState } from "react";
import { Navigate, Outlet, NavLink, useLocation } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";
import logo from "../assets/logo.png";
import logoDark from "../assets/logoDark.png";
import { IoSunny, IoMoon } from "react-icons/io5";

const navigation = [
    { name: 'Dashboard', to: '/dashboard' },
    { name: 'About', to: '/about' },
    { name: 'Events', to: '/events' },
    { name: 'Members', to: '/members' },
    { name: 'Login', to: '/login' },
    { name: 'Register', to: '/register' },
]

function classNames(...classes) {
    return classes.filter(Boolean).join(' ')
}

export default function DefaultLayout() {
    const { user, token } = useStateContext();
    const [darkMode, setDarkMode] = useState(false);
    const location = useLocation();

    const toggleDarkMode = () => {
        setDarkMode(!darkMode);
        if (darkMode) {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    };

    const filteredNavigation = navigation.filter(item => {
        if (item.name === 'Login' && token) {
            return false;
        }
        if (item.name === 'Register' && token) {
            return false;
        }
        if (item.name === 'Register' && location.pathname !== '/register') {
            return false;
        }
        if (item.name === 'Login' && location.pathname === '/register') {
            return false;
        }
        return true;
    });

    return (
        <div className={`flex min-h-screen flex-1 flex-col px-6 lg:px-8 ${darkMode ? 'bg-[#142D55]' : 'bg-white'}`}>
            <div className={`flex items-center justify-between p-2 px-3 mx-6 rounded-xl shadow-xl ${darkMode ? 'bg-[#142D55] text-white' : 'bg-white text-[#142D55]'}`}>
                {/* Logo */}
                <div className="flex items-center space-x-4">
                    <img
                        className={`h-8 w-8 rounded-md ${darkMode ? 'bg-white' : 'bg-[#142D55]'}`}
                        src={`${darkMode ? logoDark : logo}`}
                        alt="Serang Coding Community"
                    />
                    <NavLink
                        to="/"
                        className="font-semibold"
                    >
                        Serang Coding Community
                    </NavLink>
                    <button onClick={toggleDarkMode} className={`rounded-xl text-xl font-semibold ${darkMode ? 'text-white' : 'text-[#142D55]'} hover:scale-110`}>
                        {darkMode ? <IoMoon /> : <IoSunny />}
                    </button>
                </div>

                {/* Navigation */}
                <div className="hidden md:flex items-center space-x-5">
                    {filteredNavigation.map((item) => {
                        if (item.name === 'Login' && token) {
                            return null;
                        }
                        if (item.name === 'Register' && token) {
                            return null;
                        }
                        return (
                            <NavLink
                                key={item.name}
                                to={item.to}
                                className={({ isActive }) => classNames(
                                    'rounded-xl px-3 text-sm font-medium',
                                    isActive
                                        ? darkMode ? 'bg-white text-[#142D55]' : 'bg-[#142D55] text-white'
                                        : darkMode ? 'bg-[#142D55] text-white hover:bg-white hover:text-[#142D55]' : 'bg-white text-[#142D55] hover:bg-[#142D55] hover:text-white',
                                )}
                            >
                                {item.name}
                            </NavLink>
                        );
                    })}
                </div>
            </div>

            <Outlet />

        </div>
    )
}