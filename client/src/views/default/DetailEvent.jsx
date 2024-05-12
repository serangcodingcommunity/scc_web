import React from 'react'

function DetailEvent() {
    return (
        <section className='flex flex-col mt-10'>
            <main>
                <div className='h-auto max-w-full'>
                    <img
                        src="https://plus.unsplash.com/premium_photo-1676139292936-a2958a0d7177?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="event image"
                    />
                </div>
                <div></div>
                <article></article>
            </main>
            <aside className='order-first mb-5 text-white bg-primary rounded-md shadow-sm shadow-primary'>
                <div>
                    <span>Hitung Mundur</span>
                    <div>
                        <div>
                            <span>1</span>
                            <span>Hari</span>
                        </div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </aside>
        </section>
    )
}

export default DetailEvent
