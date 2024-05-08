import React from 'react'

export default function CategoryListItem({category}) {
    return (
        <div className='flex flex-col py-4 px-6 shadow-md bg-white hover:bg-gray-50 h-[470px]'>
            <h4 className='text-lg font-bold'>{category.title}</h4>
            <p className='text-sm'>{category.slug}</p>
        </div>
    )
}
