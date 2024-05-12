import React from 'react'
import notFound from '../assets/404.png'
import { useLocation } from 'react-router-dom';

const NotFound = () => {

    const location = useLocation();
    const isLocalhost = window.location.hostname === 'localhost' && window.location.port === '3000';
    if (!isLocalhost) {
        return null;
    }

    return (
        <div className="flex flex-col items-center justify-center mt-32 shadow rounded-xl p-8 mx-96 bg-white">
            <img src={notFound} className='w-48 h-48'></img>
            <h1 className="text-lg font-bold mt-5 md:text-xl">~ What are you looking for oni chan! ~</h1>
            <p className="text-lg mt-2">please go back</p>
            <button onClick={() => window.location.href = '/'} className='bg-[#142D55] text-white p-2 mt-3 rounded-xl hover:scale-105'>back to home</button>
        </div>
    )
}

export default NotFound
