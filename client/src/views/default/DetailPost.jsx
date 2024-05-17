import React from 'react'
import { useStateContext } from '../../contexts/ContextProvider'
import { IoChatbubbleEllipsesSharp } from "react-icons/io5";

import Title from '../../components/widgets/Title'
import Banner from '../../components/widgets/Banner';
import CommentSection from '../../components/CommentSection';

function DetailPost({ title }) {
  const { darkMode, toggleDarkMode } = useStateContext();

  return (
    <section className='grid grid-cols-1 font-sans my-5 space-y-5 md:mx-6 lg:mx-8'>
      <Title title={title} icon={<IoChatbubbleEllipsesSharp />} darkMode={darkMode} />

      <div className='lg:max-w-3xl lg:mx-auto'>
        <div className='bg-white box-border shadow-md'>
          <div className='flex flex-col md:flex-row md:space-x-3'>
            <div className='md:max-w-sm'>
              <Banner
                src="https://plus.unsplash.com/premium_photo-1676139292936-a2958a0d7177?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Post image"
              />
            </div>


            <div className='flex flex-col px-2 my-2 space-y-2'>
              <span className='text-xs bg-primary text-white w-fit px-2 rounded-full '>Technology</span>
              <span className='text-desc'>06 May 2024</span>
              <span>Lorem Ipsum : Dolor sit amet</span>
              <span className='text-sm text-desc'>Created by : VINN</span>
              <div className='flex items-center space-x-1 text-lg'>
                <IoChatbubbleEllipsesSharp className='text-primary' />
                <span className='text-xs'>123 Comments</span>
              </div>
              <div className='flex items-center space-x-1'>
                <span className='bg-primary p-1 text-[8px] rounded-full'>🤍</span>
                <span className='text-xs'>123 Likes</span>
              </div>
            </div>
          </div>

          <article className='text-justify px-2 mt-5 md:mb-5'>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut magna ac turpis lobortis consectetur. Integer varius felis sed nunc ultrices suscipit. Sed consequat efficitur orci non ultricies. Cras viverra sapien ut fermentum tincidunt. Suspendisse potenti. Sed vestibulum magna id lacinia sagittis. Integer sodalesipsum ut lectus consectetur, vitae molestie ante tristique. Suspendisse sit amet mauris nec sapien convallisultricies. Etiam non ultricies velit. Sed posuere viverra felis, vitae fermentum neque tristique at. Donec nec felis vitae arcu eleifend efficitur. Ut id nibh in odio ultricies accumsan. Sed sed lorem fermentum, efficitur orci eget,faucibus odio. Curabitur porta est nec risus malesuada, quis venenatis ex efficitur. Cras pharetra eros in nulla fermentum bibendum. Etiam hendrerit luctus turpis, eget ultricies leo feugiat sit amet.
          </article>
        </div>

        <div className='bg-red-500'>
          <CommentSection />
        </div>

        <h4 className='text-primary underline font-bold mt-5 mb-3 md:text-2xl'>Posts Lainnya</h4>

        <div className='grid grid-cols-1 space-y-5 md:grid-cols-2 md:space-y-0 md:gap-7 lg:grid-cols-3 lg:gap-5'>
          <div className='grid grid-cols-1'>
            <div className='bg-bgPrimary p-4 rounded-2xl space-y-4'>
              <Banner
                src="https://plus.unsplash.com/premium_photo-1676139292936-a2958a0d7177?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Post image"
              />

              <div className='flex flex-col space-y-2'>
                <div className='flex justify-between'>
                  <h4 className='underline font-bold text-primary'>Lorem Ipsum</h4>
                  <div className='flex items-center space-x-1'>
                    <span className='bg-primary  text-sm rounded-full'>🤍</span>
                    <span className='text-xs'>123 Likes</span>
                  </div>
                </div>

                <p className='text-sm text-justify'>consectetur adipiscing elit. Nullam ac hendrerit diamPhasellus fermentum, justo quis congue fermentum,velit tellus venenatis turpis, eget lobortis nulla risus nec enim</p>

                <div className='flex justify-between'>
                  <div className='flex items-center text-primary text-xl space-x-1'>
                    <IoChatbubbleEllipsesSharp />
                    <p className='text-sm'>123 Comments</p>
                  </div>
                  <p className='text-sm'>1 month ago</p>
                </div>
              </div>
            </div>
          </div>

          <div className='grid grid-cols-1'>
            <div className='bg-bgPrimary p-4 rounded-2xl space-y-4'>
              <Banner
                src="https://plus.unsplash.com/premium_photo-1676139292936-a2958a0d7177?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Post image"
              />

              <div className='flex flex-col space-y-2'>
                <div className='flex justify-between'>
                  <h4 className='underline font-bold text-primary'>Lorem Ipsum</h4>
                  <div className='flex items-center space-x-1'>
                    <span className='bg-primary  text-sm rounded-full'>🤍</span>
                    <span className='text-xs'>123 Likes</span>
                  </div>
                </div>

                <p className='text-sm text-justify'>consectetur adipiscing elit. Nullam ac hendrerit diamPhasellus fermentum, justo quis congue fermentum,velit tellus venenatis turpis, eget lobortis nulla risus nec enim</p>

                <div className='flex justify-between'>
                  <div className='flex items-center text-primary text-xl space-x-1'>
                    <IoChatbubbleEllipsesSharp />
                    <p className='text-sm'>123 Comments</p>
                  </div>
                  <p className='text-sm'>1 month ago</p>
                </div>
              </div>
            </div>
          </div>

          <div className='grid grid-cols-1'>
            <div className='bg-bgPrimary p-4 rounded-2xl space-y-4'>
              <Banner
                src="https://plus.unsplash.com/premium_photo-1676139292936-a2958a0d7177?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Post image"
              />

              <div className='flex flex-col space-y-2'>
                <div className='flex justify-between'>
                  <h4 className='underline font-bold text-primary'>Lorem Ipsum</h4>
                  <div className='flex items-center space-x-1'>
                    <span className='bg-primary  text-sm rounded-full'>🤍</span>
                    <span className='text-xs'>123 Likes</span>
                  </div>
                </div>

                <p className='text-sm text-justify'>consectetur adipiscing elit. Nullam ac hendrerit diamPhasellus fermentum, justo quis congue fermentum,velit tellus venenatis turpis, eget lobortis nulla risus nec enim</p>

                <div className='flex justify-between'>
                  <div className='flex items-center text-primary text-xl space-x-1'>
                    <IoChatbubbleEllipsesSharp />
                    <p className='text-sm'>123 Comments</p>
                  </div>
                  <p className='text-sm'>1 month ago</p>
                </div>
              </div>
            </div>
          </div>

          <div className='grid grid-cols-1'>
            <div className='bg-bgPrimary p-4 rounded-2xl space-y-4'>
              <Banner
                src="https://plus.unsplash.com/premium_photo-1676139292936-a2958a0d7177?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Post image"
              />

              <div className='flex flex-col space-y-2'>
                <div className='flex justify-between'>
                  <h4 className='underline font-bold text-primary'>Lorem Ipsum</h4>
                  <div className='flex items-center space-x-1'>
                    <span className='bg-primary  text-sm rounded-full'>🤍</span>
                    <span className='text-xs'>123 Likes</span>
                  </div>
                </div>

                <p className='text-sm text-justify'>consectetur adipiscing elit. Nullam ac hendrerit diamPhasellus fermentum, justo quis congue fermentum,velit tellus venenatis turpis, eget lobortis nulla risus nec enim</p>

                <div className='flex justify-between'>
                  <div className='flex items-center text-primary text-xl space-x-1'>
                    <IoChatbubbleEllipsesSharp />
                    <p className='text-sm'>123 Comments</p>
                  </div>
                  <p className='text-sm'>1 month ago</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}

export default DetailPost
