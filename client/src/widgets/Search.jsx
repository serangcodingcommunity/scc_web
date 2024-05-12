import React from 'react'

function Search({ icon }) {
    return (
        <form className="flex items-center max-w-lg mx-auto md:max-w-md lg:mx-0">
            <div className="relative w-full">
                <div className="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    {icon}
                </div>
                <input
                    type="text"
                    className="bg-bgPrimary border border-black text-black placeholder:text-black placeholder:text-lg text-sm rounded-full focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search ..."
                    required />
            </div>
        </form>
    )
}

export default Search
