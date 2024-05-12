import React from 'react'

function Title({ title, icon }) {
    return (
        <div className='flex items-center space-x-2 text-primary text-3xl font-bold md:mx-3 md:mt-3 md:text-5xl lg:text-3xl lg:mb-10'>
            {icon}
            <span className='underline text-xl tracking-tight font-bold md:text-3xl lg:text-2xl'>
                {title}
            </span>
        </div>
    )
}

export default Title
