import { Link } from 'react-router-dom';
import { useStateContext } from '../../../contexts/ContextProvider';
import noImage from "../../../assets/noImage.svg";
import { IoHeartCircleSharp } from "react-icons/io5";
import { FaCommentDots } from "react-icons/fa";


const Post = () => {
    const { darkMode, toggleDarkMode } = useStateContext();

    return (
        <section className="mt-20 shadow-md border rounded-md bg-white">
            <div className='container text-center mb-0 md:mb-5'>
                <Link to='/posts'>
                    <button className='text-[#142D55] rounded-md mt-8 text-xl md:text-2xl font-bold underline'>
                        Posts
                    </button>
                </Link>
            </div>

            <div className='container mx-auto mt-5 md:mt-12 px-0 md:px-5 text-left grid grid-cols-1 md:grid-cols-3 space-y-6 md:space-y-0'>

                <div className='col-span-3 md:col-span-1'>
                    <div className='bg-[#E9E9E9] py-6 mx-6 rounded-xl'>
                        <div className='bg-white py-12 mx-6 rounded-xl'>
                            <img src={noImage} alt='' className='ml-2 md:ml-8 max-h-16 md:max-h-full mx-auto' />
                        </div>
                        <div className='mx-6 md:mx-8'>
                            <div className='flex justify-between mt-3'>
                                <p className='text-sm font-bold underline'>Lorem Ipsum</p>
                                    <div className='flex justify-between'>
                                        <IoHeartCircleSharp className='text-lg' />
                                        <span className='mx-1 text-sm'>123 Like</span>
                                    </div>
                            </div>
                            <p className='text-xs mt-4 text-[#4E4E4E] '>
                                consectetur adipiscing elit. Nullam ac hendrerit diam.
                                Phasellus fermentum, justo quis congue fermentum, 
                                velit tellus venenatis turpis, eget lobortis nulla risus nec enim
                            </p>
                            <div className='flex justify-between mt-3'>
                                <div className='flex justify-between'>
                                    <FaCommentDots className='text-lg' />
                                        <span className='mx-1 text-sm'>123 Comment</span>
                                    </div>
                                <p className='text-xs'>1 Month ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div className='col-span-3 md:col-span-1'>
                    <div className='bg-[#E9E9E9] py-6 mx-6 rounded-xl'>
                        <div className='bg-white py-12 mx-6 rounded-xl'>
                            <img src={noImage} alt='' className='ml-2 md:ml-8 max-h-16 md:max-h-full mx-auto' />
                        </div>
                        <div className='mx-6 md:mx-8'>
                            <div className='flex justify-between mt-3'>
                                <p className='text-sm font-bold underline'>Lorem Ipsum</p>
                                    <div className='flex justify-between'>
                                        <IoHeartCircleSharp className='text-lg' />
                                        <span className='mx-1 text-sm'>123 Like</span>
                                    </div>
                            </div>
                            <p className='text-xs mt-4 text-[#4E4E4E] '>
                                consectetur adipiscing elit. Nullam ac hendrerit diam.
                                Phasellus fermentum, justo quis congue fermentum, 
                                velit tellus venenatis turpis, eget lobortis nulla risus nec enim
                            </p>
                            <div className='flex justify-between mt-3'>
                                <div className='flex justify-between'>
                                    <FaCommentDots className='text-lg' />
                                        <span className='mx-1 text-sm'>123 Comment</span>
                                    </div>
                                <p className='text-xs'>1 Month ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div className='col-span-3 md:col-span-1'>
                    <div className='bg-[#E9E9E9] py-6 mx-6 rounded-xl'>
                        <div className='bg-white py-12 mx-6 rounded-xl'>
                            <img src={noImage} alt='' className='ml-2 md:ml-8 max-h-16 md:max-h-full mx-auto' />
                        </div>
                        <div className='mx-6 md:mx-8'>
                            <div className='flex justify-between mt-3'>
                                <p className='text-sm font-bold underline'>Lorem Ipsum</p>
                                    <div className='flex justify-between'>
                                        <IoHeartCircleSharp className='text-lg' />
                                        <span className='mx-1 text-sm'>123 Like</span>
                                    </div>
                            </div>
                            <p className='text-xs mt-4 text-[#4E4E4E] '>
                                consectetur adipiscing elit. Nullam ac hendrerit diam.
                                Phasellus fermentum, justo quis congue fermentum, 
                                velit tellus venenatis turpis, eget lobortis nulla risus nec enim
                            </p>
                            <div className='flex justify-between mt-3'>
                                <div className='flex justify-between'>
                                    <FaCommentDots className='text-lg' />
                                        <span className='mx-1 text-sm'>123 Comment</span>
                                    </div>
                                <p className='text-xs'>1 Month ago</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div className='text-center mt-16 mb-8 hover:scale-105'>
                <Link to='/posts'>
                    <button className='text-[#142D55] text-xs'>
                        See all posts
                    </button>
                </Link>
            </div>

        </section>
    )
}

export default Post
