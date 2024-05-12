import React, { useState } from "react";
import { Navigate, Outlet, NavLink, useLocation } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";
import logo from "../assets/logo.png";
import { IoSunny, IoMoon, IoMenuOutline, IoClose } from "react-icons/io5";

const navigation = [
    { name: 'Home', to: '/' },
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
    const location = useLocation();
    const { darkMode, toggleDarkMode } = useStateContext();
    const [isSidebarOpen, setIsSidebarOpen] = useState(false);

    const filteredNavigation = navigation.filter(item => {
        if (item.name === 'Login' && token) {
            return false;
        }
        if (item.name === 'Register' && token) {
            return false;
        }
        if (item.name === 'Dashboard' && !token) {
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


    const toggleSidebar = () => {
        setIsSidebarOpen(!isSidebarOpen);
    };

    return (
        <div className={`flex min-h-screen flex-1 flex-col px-6 ${darkMode ? 'bg-[#252f3f]' : 'bg-white'}`}>
            <div className={`fixed top-0 left-0 right-0 z-50 mx-6 flex items-center justify-between mt-5 p-2 border rounded-xl shadow-xl ${darkMode ? 'bg-[#FFFFFF] text-white' : 'bg-white text-[#142D55]'}`}>
                {/* Logo */}
                <div className="flex items-center md:space-x-5 space-x-9">
                    <img
                        className='h-8 w-8 rounded-md bg-[#142D55]'
                        src={logo}
                        alt="Serang Coding Community"
                    />
                    <NavLink
                        to="/"
                        className="font-semibold text-md text-[#142D55]"
                    >
                        Serang Coding Community
                    </NavLink>
                    <button onClick={toggleDarkMode} className='rounded-xl text-xl font-semibold text-[#142D55] hover:scale-110'>
                        {darkMode ? <IoMoon /> : <IoSunny />}
                    </button>
                    <button onClick={toggleSidebar} className="md:hidden rounded-xl text-xl text-[#142D55] ">
                        {isSidebarOpen ? <IoClose /> : <IoMenuOutline />}
                    </button>
                </div>
                

                {/* Sidebar */}
                <div className={`md:hidden fixed inset-y-0 left-0 z-50 bg-[rgba(0,0,0,0.5)] transition-opacity ${isSidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'}`}>
                    <div className={`transform fixed inset-y-0 left-0 max-w-sm w-full bg-slate-50 overflow-y-auto ease-in-out transition-transform duration-300 ${isSidebarOpen ? 'translate-x-0' : '-translate-x-full'}`}>
                        <nav className="px-4 py-8">
                            {filteredNavigation.map((item) => {
                                if ((item.name === 'Login' && token) || (item.name === 'Register' && token) || (item.name === 'Login' && location.pathname === '/register')) {
                                    return null;
                                }
                                return (
                                    <NavLink
                                        key={item.name}
                                        to={item.to}
                                        onClick={toggleSidebar}
                                        className={({ isActive }) => classNames(
                                            'block py-2 px-4 text-sm font-medium rounded',
                                            isActive ? 'bg-gray-200 text-gray-800' : 'text-[#142D55] hover:bg-gray-200',
                                        )}
                                    >
                                        {item.name}
                                    </NavLink>
                                );
                            })}
                        </nav>
                    </div>
                </div>

                {/* Navigation */}
                <div className="hidden md:flex items-center space-x-5">
                    {filteredNavigation.map((item) => {
                        return (
                            <NavLink
                                key={item.name}
                                to={item.to}
                                className={({ isActive }) => classNames(
                                    'rounded-xl px-3 text-sm font-medium',
                                    isActive ? 'bg-[#142D55] text-white hover:bg-white hover:text-[#142D55]' : 'bg-white text-[#142D55] hover:bg-[#142D55] hover:text-white',
                                )}
                            >
                                {item.name}
                            </NavLink>
                        );
                    })}
                </div>

            </div>
                <div className="mt-20">
                    <Outlet />
                </div>
        </div>
    )
}