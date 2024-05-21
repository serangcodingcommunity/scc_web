import React from 'react'

function UserParticipation({ status, button }) {
    return (
        <>
            <span className='bg-[#FF8F8F] text-white py-1 text-center lg:px-3 '>{status}</span>
            <span className='bg-primary text-white py-1 text-center lg:px-3 '>{button}</span>
        </>
    )
}

export default UserParticipation
