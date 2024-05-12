import React, { useState } from 'react'
import ReactPaginate from 'react-paginate';
import { useStateContext } from '../../../contexts/ContextProvider';
import {
    RiCalculatorLine,
    RiSearchLine,
    RiArrowLeftSLine,
    RiArrowRightSLine
} from "react-icons/ri";
import Title from '../../../components/widgets/Title'
import Search from '../../../components/widgets/Search'
import maleUser from "../../../assets/maleUser.svg";
import { useNavigate } from 'react-router-dom';

const Member = ({ title }) => {
    const [currentPage, setCurrentPage] = useState(0);
    const { darkMode, toggleDarkMode } = useStateContext();
    const navigate = useNavigate();

    const handlePageClick = ({ selected }) => {
        setCurrentPage(selected);
    };

    const handleClick = (id) => {
        navigate(`/member/${id}`);
    };

    return (
        <div className='grid grid-cols-1 font-sans my-5 space-y-5 md:mx-6 lg:mx-8'>

            <Title title={title} icon={<RiCalculatorLine />} darkMode={darkMode} />

            <div className=' lg:max-w-xl'>
                <Search icon={<RiSearchLine />} />
            </div>

            <div className='bg-white box-border px-2 py-5 shadow-md border rounded-md'>
                <div className='container mx-auto my-5 px-0 md:px-5 text-left grid grid-cols-6 md:grid-cols-5 gap-3'>

                    <button onClick={() => handleClick('id')} >
                        <div className='col-span-3 md:col-span-1'>
                            <button className='bg-[#142D55] p-10 mx-8 rounded-xl text-white text-center'>
                                <img src={maleUser} alt='' className='max-h-16 md:max-h-full mx-auto' />
                                <h3 className='text-md'>Alvin Malak</h3>
                                <p className='text-xs'>Backend Developer</p>
                            </button>
                        </div>
                    </button>

                    <button onClick={() => handleClick('id')} >
                        <div className='col-span-3 md:col-span-1'>
                            <button className='bg-[#142D55] p-10 mx-8 rounded-xl text-white text-center'>
                                <img src={maleUser} alt='' className='max-h-16 md:max-h-full mx-auto' />
                                <h3 className='text-md'>Alvin Malik</h3>
                                <p className='text-xs'>Backend Developer</p>
                            </button>
                        </div>
                    </button>

                    <button onClick={() => handleClick('id')} >
                        <div className='col-span-3 md:col-span-1'>
                            <button className='bg-[#142D55] p-10 mx-8 rounded-xl text-white text-center'>
                                <img src={maleUser} alt='' className='max-h-16 md:max-h-full mx-auto' />
                                <h3 className='text-md'>Alvin Maluk</h3>
                                <p className='text-xs'>Backend Developer</p>
                            </button>
                        </div>
                    </button>

                    <button onClick={() => handleClick('id')} >
                        <div className='col-span-3 md:col-span-1'>
                            <button className='bg-[#142D55] p-10 mx-8 rounded-xl text-white text-center'>
                                <img src={maleUser} alt='' className='max-h-16 md:max-h-full mx-auto' />
                                <h3 className='text-md'>Alvin Malek</h3>
                                <p className='text-xs'>Backend Developer</p>
                            </button>
                        </div>
                    </button>

                    <button onClick={() => handleClick('id')} >
                        <div className='col-span-3 md:col-span-1'>
                            <button className='bg-[#142D55] p-10 mx-8 rounded-xl text-white text-center'>
                                <img src={maleUser} alt='' className='max-h-16 md:max-h-full mx-auto' />
                                <h3 className='text-md'>Alvin Malok</h3>
                                <p className='text-xs'>Backend Developer</p>
                            </button>
                        </div>
                    </button>

                </div>
            </div>

            <div className='flex justify-center'>
                <ReactPaginate
                    pageCount={8}
                    pageRangeDisplayed={3}
                    onPageChange={handlePageClick}
                    containerClassName={'pagination'}
                    pageClassName={`hover:bg-primary hover:text-white px-1 rounded-md`}
                    previousLabel={<RiArrowLeftSLine className='hover:bg-primary hover:text-white' />}
                    nextLabel={<RiArrowRightSLine className='hover:bg-primary hover:text-white' />}
                    activeClassName={'active'}
                    className='flex items-center space-x-3 py-2 px-5 rounded-2xl bg-bgPagination'
                />
            </div>
        </div>
    )
}

export default Member
