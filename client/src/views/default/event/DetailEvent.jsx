import React from 'react'
import { useStateContext } from '../../../contexts/ContextProvider';
import Banner from '../../../components/widgets/Banner';
import UserParticipation from '../../../components/widgets/UserParticipation';

import {
    RiMapPin2Fill,
} from "react-icons/ri";

function DetailEvent() {
    const { darkMode, toggleDarkMode } = useStateContext();

    return (
        <section className='flex flex-col my-10 md:flex-row md:justify-between lg:justify-end'>
            <main className='flex flex-col space-y-2 md:w-8/12'>
                <div className='h-auto max-w-full'>
                    <Banner
                        src={"https://plus.unsplash.com/premium_photo-1676139292936-a2958a0d7177?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"}
                        alt="event image"
                    />
                </div>
                <div className='text-xs space-y-2 md:flex md:justify-between items-center'>
                    <div className='text-white  flex space-x-2'>
                        <span className={`px-5 py-1 rounded-2xl font-bold ${darkMode ? 'bg-white text-primary' : 'bg-primary text-white'}`}>Published</span>
                        <span className={`px-5 py-1 rounded-2xl font-bold ${darkMode ? 'bg-white text-primary' : 'bg-primary text-white'}`}>Upcoming</span>
                    </div>
                    <div className={`${darkMode ? 'text-white' : 'text-black'}`}>
                        <span>Published Jan 20, 2024 at 18:14 · 4 months ago</span>
                    </div>
                </div>
                <article className='bg-white shadow-md md:box-border py-5 px-3 rounded-md md:drop-shadow-sm'>
                    <h1 className='text-xl font-bold text-primary'>LOREM IPSUM : DOLOR SIT AMET</h1>
                    <p className='text-justify'>
                        Kotlin merupakan bahasa pemrograman open source yang statis. Kotlin dapat berjalan pada platform JVM (Java Virtual Machine) yang memungkinkan program berbasis Java atau bahas lain yang sudah di complie ke dalam bahasa Java dapat berjalan. Kotlin menggunakan compiler LLVM yang bisa dikompilasikan kedalam kode JavaScript. Kotlin dapat digunakan untuk berbagai platform seperti pembuatan aplikasi web, server, dan Android. Tapi Kotlin lebih populer untuk digunakan dalam pembuatan platform Android. Untuk membuat aplikasi Android tentunya ada beberapa hal yang harus dipelajari dan dipersiapkan, mau tau apa aja?

                        Cari tahu lebih lanjut dengan cara mengikuti Workshop Dunia Coding yang berjudul “Membuat Aplikasi Berita Menggunakan Kotlin”. Di workshop ini kalian akan belajar tentang Pengenalan Kotlin dan Struktur Aplikasi Android, RecycleView untuk mengelola Data, Mengintegrasikan API, sampai pembuatan Aplikasi Berita. Semua itu akan disampaikan oleh Achmad Chadil Auwfar sebagai Lead Android Platform di Aloodokter. Tidak hanya mengajarkan tentang pembuatan aplikasi berita menggunakan Kotlin, kak Auwfar juga mengajarkan cara Debugging saat ngoding agar tidak panik saat BUG.

                        Term & Condition
                        Event ini terbuka untuk umum.
                        Peserta diharapakan join ke grup WA dengan klik join grup setelah mendaftar atau pada dashboard.
                        Segala informasi terkait event (termasuk link room) akan dishare melalui grup whatsapp.
                        Peserta Wajib Mengikuti Aturan yang Telah ditentukan Oleh Serang Coding Community
                    </p>
                </article>
            </main>
            <aside className='order-first text-white md:order-last md:box-border md:px-5 lg:w-1/4 lg:ml-5'>
                <div className='bg-primary w-full space-y-2 box-border py-5 rounded-md flex flex-col items-center font-bold md:px-3'>
                    <span className='text-center'>Hitung Mundur</span>
                    <div className='flex space-x-3'>
                        <div className='flex flex-col items-center'>
                            <span className='bg-white w-fit px-3 rounded-md py-2 text-primary text-center'>1</span>
                            <span className='text-sm'>Hari</span>
                        </div>
                        <div className='flex flex-col items-center'>
                            <span className='bg-white w-fit px-3 rounded-md py-2 text-primary text-center'>1</span>
                            <span className='text-sm'>Jam</span>
                        </div>
                        <div className='flex flex-col items-center'>
                            <span className='bg-white w-fit px-3 rounded-md py-2 text-primary text-center'>1</span>
                            <span className='text-sm'>Menit</span>
                        </div>
                        <div className='flex flex-col items-center'>
                            <span className='bg-white w-fit px-3 rounded-md py-2 text-primary text-center'>1</span>
                            <span className='text-sm'>Detik</span>
                        </div>
                    </div>
                </div>

                <div className='text-black space-y-3 bg-white shadow-sm rounded-sm py-2 mt-2 px-2'>
                    <div className='font-bold flex flex-col'>
                        <span className='text-bgPagination'>Tutup :</span>
                        <span>May 25, 2024</span>
                    </div>
                    <div className='font-bold flex flex-col'>
                        <span className='text-bgPagination'>Kuota :</span>
                        <span>Tersedia</span>
                    </div>
                    <div className='flex flex-col space-y-2 lg:w-fit'>
                        <span>Keikutsertaan</span>
                        <UserParticipation
                            status={"Anda Belum Terdaftar"}
                            button={"Daftar Gratis"}
                        />
                    </div>
                    <div className='flex flex-col text-xs'>
                        <span className='text-base mb-2'>Jadwal Pelaksanaan :</span>
                        <span>Mulai : 30 May 2024 : 08:00</span>
                        <span>Selesai : 14:00</span>
                    </div>
                    <div className='flex flex-col'>
                        <span>Lokasi</span>
                        <div className='flex items-center space-x-2'>
                            <RiMapPin2Fill />
                            <span className='text-desc text-sm'>Babonhok, Serang</span>
                        </div>
                    </div>
                </div>
            </aside>
        </section>
    )
}

export default DetailEvent
