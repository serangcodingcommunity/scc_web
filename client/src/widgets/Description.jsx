import React from 'react'

function Description({ title, desc, date, location, icon, button }) {
    return (
        <div className='flex flex-col space-y-3 tracking-tight'>
            <h1 className='font-bold text-primary text-xl underline md:text-2xl'>{title}</h1>
            <p className='text-sm'>{desc}</p>
            <span className='text-desc'>{date}</span>
            <div className='flex items-center space-x-1'>
                {icon}
                <span className='text-desc'>{location}</span>
            </div>
            <button className='bg-primary text-white text-xs px-6 py-2 rounded-lg hover:scale-105 transition duration-150'>{button}</button>
        </div>
    )
}

export default Description
