import React, { useState } from 'react'
import {
    RiCalculatorLine,
} from "react-icons/ri";
import { useNavigate } from 'react-router-dom';
import { useStateContext } from '../../../contexts/ContextProvider';
import Title from '../../../components/widgets/Title'

const MemberShow = ({title}) => {
    const { darkMode, token, toggleDarkMode } = useStateContext();
    const navigate = useNavigate();

    if (!token) {
        return navigate('/login');
    }
    return (
        <div className='grid grid-cols-1 font-sans my-5 space-y-5 md:mx-6 lg:mx-8'>
            <Title title={title} icon={<RiCalculatorLine />} darkMode={darkMode} />



        </div>
    )
}

export default MemberShow
