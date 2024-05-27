import React from 'react'

function Banner({ src, alt, className = null }) {
    return (
        <img src={src} alt={alt} className={`${className}`} />
    )
}

export default Banner
