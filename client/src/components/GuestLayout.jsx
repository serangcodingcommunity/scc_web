import React, { useState } from "react";
import { Navigate, Outlet, NavLink, useLocation } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";
import logo from "../assets/logo.png";
import logoDark from "../assets/logoDark.png";
import { IoSunny, IoMoon } from "react-icons/io5";

const navigation = [
    { name: 'About', to: '/' },
    { name: 'Events', to: '/events' },
    { name: 'Members', to: '/members' },
    { name: 'Login', to: '/login' },
    { name: 'Register', to: '/register' },
]

function classNames(...classes) {
    return classes.filter(Boolean).join(' ')
}

export default function GuestLayout() {
    const { currentUser, userToken } = useStateContext();
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

    if (userToken) {
        return <Navigate to="/" />;
    }

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
                    {navigation.map((item) => (
                        <NavLink
                            key={item.name}
                            to={item.to}
                            className={({ isActive }) => classNames(
                                'rounded-xl px-3 text-sm font-medium',
                                isActive
                                    ? darkMode ? 'bg-white text-[#142D55]' : 'bg-[#142D55] text-white'
                                    : darkMode ? 'bg-[#142D55] text-white hover:bg-white hover:text-[#142D55]' : 'bg-white text-[#142D55] hover:bg-[#142D55] hover:text-white',
                                location.pathname === '/login' && item.name === 'Register' ? 'hidden' : '',
                                location.pathname === '/register' && item.name === 'Login' ? 'hidden' : ''
                            )}
                        >
                            {location.pathname === '/login' && item.name === 'Register' ? 'Login' : location.pathname === '/register' && item.name === 'Login' ? 'Register' : item.name}
                        </NavLink>
                    ))}
                </div>
            </div>

            <div className="mt-20 sm:mx-auto sm:w-full sm:max-w-sm rounded-lg p-5 shadow-xl border-2 border-slate-50 relative bg-white">
                <span className="absolute top-0 left-1/2 transform -translate-x-1/2 w-1/4 h-4 rounded-md bg-[#142D55]"></span>
                <Outlet />
            </div>
        </div>
    );
};
