import { Link } from 'react-router-dom';
import { useStateContext } from '../../../contexts/ContextProvider';
import noImage from "../../../assets/noImage.svg";
import { FaTelegramPlane, FaInstagram, FaYoutube } from "react-icons/fa";

const Footer = () => {
    const { darkMode, toggleDarkMode } = useStateContext();

    return (
        <section className="mt-12">

            <div className='container grid grid-cols-6 md:grid-cols-5 gap-3'>
                <div className='col-span-3 md:col-span-1 shadow-md border rounded-md bg-white'>
                    <div className=' py-10 mx-8 rounded-xl text-left'>
                        <img src={noImage} alt='' className='max-h-16 md:max-h-full mx-auto' />
                        <h3 className='text-md mt-3'>Social Media</h3>

                        <div className='flex mt-20 gap-1'>
                        <a href="https://t.me/serangcodingcommunity" target="_blank" rel="noreferrer" className='p-1 rounded-xl text-white bg-[#142D55]'>
                            <FaTelegramPlane size={30} />
                        </a>
                        <a href="https://www.instagram.com/serangcodingcommunity/" target="_blank" rel="noreferrer" className='p-1 rounded-xl  text-white bg-[#142D55]'>
                            <FaInstagram size={30} />
                        </a>
                        <a href="https://www.youtube.com/channel/UCY5wq5hK5c2nCqF9uV7s8VQ" target="_blank" rel="noreferrer" className='p-1 rounded-xl  text-white bg-[#142D55]'>
                            <FaYoutube size={30} />
                        </a>
                    </div>
                    </div>
                </div>

                <div className='col-span-3 md:col-span-4 shadow-md border rounded-md bg-white'>
                    <div className='rounded-xl text-center'>
                        <div className='container grid grid-cols-6 md:grid-cols-4 gap-3'>

                            <div className='col-span-3 md:col-span-1'>
                                <div className='py-10 mx-8 rounded-xl text-center space-y-2'>
                                    <h3 className='text-md font-bold'>Pages</h3>
                                    <Link to='/' className='text-xs'>Home</Link><br />
                                    <Link to='/about'  className='text-xs'>About</Link><br />
                                    <Link to='/members'  className='text-xs'>Member</Link><br />
                                    <Link to='/events'  className='text-xs'>Event</Link><br />
                                    <Link to='/post'  className='text-xs'>Post</Link>
                                </div>
                            </div>

                            <div className='col-span-3 md:col-span-1'>
                                <div className='py-10 mx-8 rounded-xl text-center space-y-2'>
                                    <h3 className='text-md font-bold'>Links</h3>
                                    <a href='/' className='text-xs'>Telegram</a><br />
                                    <a href='/' className='text-xs'>Instagram</a><br />
                                    <a href='/' className='text-xs'>Youtube</a>
                                </div>
                            </div>

                            <div className='col-span-3 md:col-span-1'>
                                <div className='py-10 mx-8 rounded-xl text-center space-y-2'>
                                    <h3 className='text-md font-bold'>Sponsor</h3>
                                    <p className='text-xs'>Lorem Ipsum</p>
                                    <p className='text-xs'>Lorem Ipsum</p>
                                    <p className='text-xs'>Lorem Ipsum</p>
                                </div>
                            </div>

                            <div className='col-span-3 md:col-span-1'>
                                <div className='py-10 mx-8 rounded-xl text-center space-y-2'>
                                    <h3 className='text-md font-bold'>Partner</h3>
                                    <p className='text-xs'>Lorem Ipsum</p>
                                    <p className='text-xs'>Lorem Ipsum</p>
                                    <p className='text-xs'>Lorem Ipsum</p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>


            <div className='text-center mt-16 mb-8 hover:scale-105'>
                <Link to='/'>
                    <button className={`text-xs ${darkMode ? 'text-white' : 'text-[#142D55] '}`}>
                        All rights reserved. Copyright © 2024 Serang Coding Community
                    </button>
                </Link>
            </div>

        </section>
    )
}

export default Footer
