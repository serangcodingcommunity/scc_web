import { Link } from 'react-router-dom';

import logo from '../../../assets/logo.png';
import logoDark from '../../../assets/logoDark.png';
import { useStateContext } from '../../../contexts/ContextProvider';
import { FaTelegramPlane, FaInstagram, FaYoutube } from "react-icons/fa";

const Hero = () => {
    const { darkMode, toggleDarkMode } = useStateContext();

    return (
        <section id='hero' className="flex justify-center items-center mt-10">
            <div className='container mx-auto text-center flex flex-col items-center md:flex md:flex-col md:justify-center md:items-center'>

                <img src={`${darkMode ? logoDark : logo}`} alt='Serang Coding Community' className={`w-32 h-32 mt-12 rounded-xl ${darkMode ? 'bg-white' : 'bg-black'}`} />
                <div className='mt-6'>
                    <h1 className={`text-3xl md:text-5xl ${darkMode ? 'text-white' : 'text-black'}`}>
                        Serang Coding Community
                    </h1>
                    <p className={`md:px-96 text-xs md:text-base mt-2 md:mt-5 ${darkMode ? 'text-white' : 'text-black'}`}>
                        Menjadi pusat kreativitas bagi para pelajar, mahasiswa, programmer,
                        dan penggiat teknologi lainnya untuk saling berkolaborasi dan bertukar pikiran
                        dalam menciptakan inovasi teknologi yang bermanfaat bagi masyarakat.
                    </p>
                    <Link
                        to='/register'>
                        <button className={`py-2 rounded-md mt-24 text-xl md:text-2xl font-bold ${darkMode ? 'text-white' : 'text-black'}`}>
                            JOIN US
                        </button>
                    </Link>

                    <div className='flex justify-center items-center mb-16'>
                        <a href="https://t.me/serangcodingcommunity" target="_blank" rel="noreferrer" className={`mx-2 p-1.5 rounded-xl ${darkMode ? 'text-[#142D55] bg-white' : 'text-white bg-[#142D55]'}`}>
                            <FaTelegramPlane size={30} />
                        </a>
                        <a href="https://www.instagram.com/serangcodingcommunity/" target="_blank" rel="noreferrer" className={`mx-2 p-1.5 rounded-xl  ${darkMode ? 'text-[#142D55] bg-white' : 'text-white bg-[#142D55]'}`}>
                            <FaInstagram size={30} />
                        </a>
                        <a href="https://www.youtube.com/channel/UCY5wq5hK5c2nCqF9uV7s8VQ" target="_blank" rel="noreferrer" className={`mx-2 p-1.5 rounded-xl  ${darkMode ? 'text-[#142D55] bg-white' : 'text-white bg-[#142D55]'}`}>
                            <FaYoutube size={30} />
                        </a>
                    </div>
                </div>
            </div>
        </section>
    )
}

export default Hero
