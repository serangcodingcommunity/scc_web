import React, { useState } from 'react'
import ReactPaginate from 'react-paginate';
import {
    RiCalculatorLine,
    RiSearchLine,
    RiMapPin2Fill,
    RiArrowLeftSLine,
    RiArrowRightSLine
} from "react-icons/ri";
import Title from '../widgets/Title'
import Search from '../widgets/Search'
import Banner from '../widgets/Banner'
import Description from '../widgets/Description'

const Event = ({ title }) => {
    const [currentPage, setCurrentPage] = useState(0);

    const handlePageClick = ({ selected }) => {
        setCurrentPage(selected);
    };

    return (
        <div className='grid grid-cols-1 font-sans my-5 space-y-5 md:mx-6 lg:mx-8'>

            <Title title={title} icon={<RiCalculatorLine />} />

            <div className='lg:max-w-xl lg:pl-8'>
                <Search icon={<RiSearchLine />} />
            </div>

            <div className='flex flex-col space-y-3 md:flex-row md:justify-evenly lg:justify-center lg:space-x-5'>
                <div className="h-auto max-w-full md:max-w-md lg:max-w-xl">
                    <Banner
                        src="https://images.unsplash.com/photo-1560523160-754a9e25c68f?q=80&w=2036&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="event image"
                    />
                </div>

                <Description
                    title="Lorem Ipsum"
                    desc="Lorem ipsum dolor sit amet"
                    date="May 01, 2024 00:00 - Selesai"
                    location="Babonhok, Serang"
                    icon={<RiMapPin2Fill />}
                    button="View Event"
                />
            </div>

            <div className='flex justify-center'>
                <ReactPaginate
                    pageCount={8} // Total number of pages
                    pageRangeDisplayed={3} // Number of pages displayed in the pagination
                    onPageChange={handlePageClick} // Callback function when a page is clicked
                    containerClassName={'pagination'}
                    pageClassName={`hover:bg-primary hover:text-white px-1 rounded-md`}
                    previousLabel={<RiArrowLeftSLine className='hover:bg-primary hover:text-white' />}
                    nextLabel={<RiArrowRightSLine className='hover:bg-primary hover:text-white' />}
                    activeClassName={'active'}
                    className='flex items-center space-x-3 py-2 px-5 rounded-2xl bg-bgPagination'
                />
            </div>

            {/* <div className='mx-auto'>
                <nav aria-label="Page navigation example">
                    <ul className="flex items-center space-x-3 h-8 text-sm">
                        <li>
                            <a href="#" className="flex items-center justify-center py-3 px-1 h-4 text-black bg-bgPagination rounded-full hover:bg-primary hover:text-white dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <RiArrowLeftSLine />
                            </a>
                        </li>
                        <div className='flex bg-bgPagination rounded-full px-5'>
                            {[1, 2, 3, 4, 5, 6, 7, 8].map((page) => (
                                <li key={page} className='flex items-center h-8'>
                                    <a href="#" className="flex items-center justify-center px-1 mx-1  rounded-md py-1 leading-tight text-black hover:bg-primary hover:text-white dark:text-gray-400 dark:hover:text-white">
                                        {page}
                                    </a>
                                </li>
                            ))}
                        </div>
                        <li>
                            <a href="#" className="flex items-center justify-center py-3 px-1 h-4 text-black bg-bgPagination rounded-full hover:bg-primary hover:text-white dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <RiArrowRightSLine />
                            </a>
                        </li>
                    </ul>
                </nav>
            </div> */}
        </div>
    )
}

export default Event
