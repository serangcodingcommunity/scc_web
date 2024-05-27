import React from 'react'
import Title from '../../components/widgets/Title'
import Banner from '../../components/widgets/Banner'
import { useStateContext } from '../../contexts/ContextProvider'
import { Swiper, SwiperSlide } from 'swiper/react'
import 'swiper/css'
// import 'swiper/css/effect-coverflow'
// import 'swiper/css/pagination'
// import 'swiper/css/navigation'
// import { EffectCoverflow, Pagination, Navigation } from 'swiper'
import { EffectCoverflow, Pagination, Navigation } from 'swiper/modules';

import { RiGalleryView2 } from "react-icons/ri";
import { GrFormPrevious, GrFormNext } from "react-icons/gr";


function Gallery({ title }) {
    const { darkMode, toggleDarkMode } = useStateContext();

    return (
        <section className='flex flex-col my-5'>
            <div className='h-fit'>
                <Title
                    title={title}
                    icon={<RiGalleryView2 />}
                    darkMode={darkMode}
                />
                <p className={`text-xs mt-2 md:ml-3 md:text-base lg:-mt-10 ${darkMode ? 'text-white ' : 'text-primary'}`}>Carving a Journey: An Album Capturing Its Own Moments</p>
            </div>

            <div className="container mt-10 mx-auto lg:mt-16">
                <Swiper
                    effect={'coverflow'}
                    grabCursor={true}
                    centeredSlides={true}
                    loop={true}
                    slidesPerView={'auto'}
                    coverflowEffect={
                        {
                            rotate: 0,
                            stretch: 0,
                            depth: 100,
                            modifier: 2.5
                        }
                    }
                    pagination={{ el: 'swiper-pagination', clickable: true }}
                    navigation={{
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                        clickable: true
                    }}
                    modules={[EffectCoverflow, Pagination, Navigation]}
                    className='relative max-w-2xl'
                >
                    <SwiperSlide className='max-w-lg'>
                        <Banner
                            src="https://plus.unsplash.com/premium_photo-1676139292936-a2958a0d7177?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Gallery image"
                            className={'rounded-xl'}
                        />
                    </SwiperSlide>
                    <SwiperSlide className='max-w-lg'>
                        <Banner
                            src="https://plus.unsplash.com/premium_photo-1676139292936-a2958a0d7177?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Gallery image"
                            className={'rounded-xl'}
                        />
                    </SwiperSlide>
                    <SwiperSlide className='max-w-lg'>
                        <Banner
                            src="https://plus.unsplash.com/premium_photo-1676139292936-a2958a0d7177?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Gallery image"
                            className={'rounded-xl'}
                        />
                    </SwiperSlide>
                    <SwiperSlide className='max-w-lg'>
                        <Banner
                            src="https://plus.unsplash.com/premium_photo-1676139292936-a2958a0d7177?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Gallery image"
                            className={'rounded-xl'}
                        />
                    </SwiperSlide>
                    <SwiperSlide className='max-w-lg'>
                        <Banner
                            src="https://plus.unsplash.com/premium_photo-1676139292936-a2958a0d7177?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Gallery image"
                            className={'rounded-xl'}
                        />
                    </SwiperSlide>


                    <div className={`slider-controller hidden w-fit mx-auto font-bold mt-5 md:flex justify-between ${darkMode ? 'text-white' : 'text-primary'}`}>
                        <div className='swiper-button-prev slider-arrow flex items-center cursor-pointer mr-12'>
                            <GrFormPrevious />
                            Previous
                        </div>
                        <div className='swiper-button-next slider-arrow flex items-center cursor-pointer'>
                            Next
                            <GrFormNext />
                        </div>
                        <div className='swiper-pagination'></div>
                    </div>
                </Swiper>
            </div>
        </section>
    )
}

export default Gallery
