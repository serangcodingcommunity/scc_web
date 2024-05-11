import { Link } from 'react-router-dom';
import { useStateContext } from '../../../contexts/ContextProvider';
import noImage from "../../../assets/noImage.svg";

const Gallery = () => {
    const { darkMode, toggleDarkMode } = useStateContext();

    return (
        <section className="mt-20 shadow-md border rounded-md bg-white">
            <div className='container text-center mb-0 md:mb-5'>
                <Link to='/galleries'>
                    <button className='text-[#142D55] rounded-md mt-8 text-xl md:text-2xl font-bold underline'>
                        Galleries
                    </button>
                </Link>
                <p className='text-sm mt-2'>Carving a Journey: An Album Capturing Its Own Moments</p>
            </div>

            <div className='container mx-auto mt-5 md:mt-12 px-0 md:px-5 text-left grid grid-cols-1 md:grid-cols-3 space-y-6 md:space-y-0'>

                <div className='col-span-3 md:col-span-1'>
                    <div className='bg-[#E9E9E9] py-40 mx-6 rounded-xl'>
                        <img src={noImage} alt='' className='max-h-32 md:max-h-full mx-auto' />
                    </div>
                </div>

                <div className='col-span-3 md:col-span-1'>
                    <div className='bg-[#E9E9E9] py-40 mx-6 rounded-xl'>
                        <img src={noImage} alt='' className='max-h-32 md:max-h-full mx-auto' />
                    </div>
                </div>

                <div className='col-span-3 md:col-span-1'>
                    <div className='bg-[#E9E9E9] py-40 mx-6 rounded-xl'>
                        <img src={noImage} alt='' className='max-h-32 md:max-h-full mx-auto' />
                    </div>
                </div>

            </div>


            <div className='text-center mt-16 mb-8 hover:scale-105'>
                <Link to='/galleries'>
                    <button className='text-[#142D55] text-xs'>
                        See all galleries
                    </button>
                </Link>
            </div>

        </section>
    )
}

export default Gallery
