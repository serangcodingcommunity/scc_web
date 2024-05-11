import { Link } from 'react-router-dom';
import { useStateContext } from '../../../contexts/ContextProvider';
import maleUser from "../../../assets/maleUser.svg";


const Member = () => {
    const { darkMode, toggleDarkMode } = useStateContext();

    return (
        <section className="mt-20 shadow-md border rounded-md bg-white">
            <div className='container text-center mb-0 md:mb-5'>
                <Link to='/members'>
                    <button className='text-[#142D55] rounded-md mt-8 text-xl md:text-2xl font-bold underline'>
                        Community Members
                    </button>
                </Link>
                <p className='text-sm mt-2'>Welcome to Our Family: Embracing New Members in Our Community</p>
            </div>

            <div className='container mx-auto mt-5 md:mt-12 px-0 md:px-5 text-left grid grid-cols-6 md:grid-cols-5 gap-3'>
                <div className='col-span-3 md:col-span-1'>
                    <div className='bg-[#142D55] py-10 mx-8 rounded-xl text-white text-center'>
                        <img src={maleUser} alt='' className='max-h-16 md:max-h-full mx-auto' />
                        <h3 className='text-md'>Alvin Malak</h3>
                        <p className='text-xs'>Backend Developer</p>
                    </div>
                </div>

                <div className='col-span-3 md:col-span-1'>
                    <div className='bg-[#142D55] py-10 mx-8 rounded-xl text-white text-center'>
                        <img src={maleUser} alt='' className='max-h-16 md:max-h-full mx-auto' />
                        <h3 className='text-md'>Alvin Malik</h3>
                        <p className='text-xs'>Backend Developer</p>
                    </div>
                </div>

                <div className='col-span-3 md:col-span-1'>
                    <div className='bg-[#142D55] py-10 mx-8 rounded-xl text-white text-center'>
                        <img src={maleUser} alt='' className='max-h-16 md:max-h-full mx-auto' />
                        <h3 className='text-md'>Alvin Maluk</h3>
                        <p className='text-xs'>Backend Developer</p>
                    </div>
                </div>

                <div className='col-span-3 md:col-span-1'>
                    <div className='bg-[#142D55] py-10 mx-8 rounded-xl text-white text-center'>
                        <img src={maleUser} alt='' className='max-h-16 md:max-h-full mx-auto' />
                        <h3 className='text-md'>Alvin Malek</h3>
                        <p className='text-xs'>Backend Developer</p>
                    </div>
                </div>

                <div className='col-span-3 md:col-span-1'>
                    <div className='bg-[#142D55] py-10 mx-8 rounded-xl text-white text-center'>
                        <img src={maleUser} alt='' className='max-h-16 md:max-h-full mx-auto' />
                        <h3 className='text-md'>Alvin Malok</h3>
                        <p className='text-xs'>Backend Developer</p>
                    </div>
                </div>
            </div>


            <div className='text-center mt-16 mb-8 hover:scale-105'>
                <Link to='/members'>
                    <button className='text-[#142D55] text-xs'>
                        See all members
                    </button>
                </Link>
            </div>

        </section>
    )
}

export default Member
