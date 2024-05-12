import { Link } from 'react-router-dom';
import { useStateContext } from '../../../contexts/ContextProvider';
import noImage from "../../../assets/noImage.svg";
import { FaMapMarkerAlt } from "react-icons/fa";

const Event = () => {
    const { darkMode, toggleDarkMode } = useStateContext();

    return (
        <section className="mt-20 shadow-md border rounded-md bg-white">
            <div className='container text-center mb-0 md:mb-5'>
                <Link to='/events'>
                    <button className='text-[#142D55] rounded-md mt-8 text-xl md:text-2xl font-bold underline'>
                        Events
                    </button>
                </Link>
            </div>

            <div className='block md:flex justify-between'>
                <div className='container mx-auto px-5 text-left'>
                    <div className='md:mx-8'>
                        <Link to='/events'>
                            <button className='text-[#142D55] rounded-md mt-5 md:mt-12 text-md md:text-xl font-bold underline'>
                                Past Event
                            </button>
                        </Link>
                        <p className='text-xs md:text-sm'>
                            Reflecting on Unforgettable Moments: Past Events Rewind
                        </p>
                    </div>

                    <div className='grid grid-cols-1 md:grid-cols-3 gap-4 mt-5'>
                        <div className='md:col-span-2 md:mx-8 bg-[#E9E9E9] py-20'>
                            <img src={noImage} alt='' className='max-h-36 md:max-h-full mx-auto' />
                        </div>
                        <div className='flex flex-col justify-center'>
                            <h5 className='text-lg font-bold underline'>Lorem Ipsum</h5>
                            <p className='text-sm'>Lorem ipsum dolor sit amet</p>
                            <p className='text-xs mt-2 text-gray-400'>May 01, 2024</p>
                            <p className='text-xs text-gray-400'>00:00 - Selesai</p>
                            <div className='flex items-center mt-2'>
                                <FaMapMarkerAlt className='text-xl' />
                                <p className='text-xs text-gray-400 ml-2'>Babunhok, Serang</p>
                            </div>
                            <Link to='/events'>
                                <button className='bg-[#142D55] text-white rounded-xl mt-5 text-xs p-1 px-2 hover:scale-105'>
                                    View Events
                                </button>
                            </Link>
                        </div>
                    </div>
                </div>

                <div className='container mx-auto px-5 text-left mt-12 md:mt-0'>
                    <div className='md:mx-8'>
                        <Link to='/events'>
                            <button className='text-[#142D55] rounded-md mt-3 md:mt-8 text-md md:text-xl font-bold underline'>
                                Upcoming Event
                            </button>
                        </Link>
                        <p className='text-xs md:text-sm'>
                            Discover the Future: Unveiling Our Upcoming Events!
                        </p>
                    </div>
                    <div className='grid grid-cols-1 md:grid-cols-3 gap-4 mt-5'>
                        <div className='md:col-span-2 md:mx-8 bg-[#E9E9E9] py-20'>
                            <img src={noImage} alt='' className='max-h-36 md:max-h-full mx-auto' />
                        </div>
                        <div className='flex flex-col justify-center'>
                            <h5 className='text-lg font-bold underline'>Lorem Ipsum</h5>
                            <p className='text-sm'>Lorem ipsum dolor sit amet</p>
                            <p className='text-xs mt-2 text-gray-400'>May 01, 2024</p>
                            <p className='text-xs text-gray-400'>00:00 - Selesai</p>
                            <div className='flex items-center mt-2'>
                                <FaMapMarkerAlt className='text-xl' />
                                <p className='text-xs text-gray-400 ml-2'>Babunhok, Serang</p>
                            </div>
                            <Link to='/events'>
                                <button className='bg-[#142D55] text-white rounded-xl mt-5 text-xs p-1 px-2 hover:scale-105'>
                                    View Events
                                </button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <div className='text-center mt-16 mb-8 hover:scale-105'>
                <Link to='/events'>
                    <button className='text-[#142D55] text-xs'>
                        See all events
                    </button>
                </Link>
            </div>

        </section>
    )
}

export default Event

