import React, { useEffect } from 'react';
import { useLocation } from 'react-router-dom';
import axiosClient from '../../axios';

const GithubCallback = () => {
    const location = useLocation();

    useEffect(() => {
        const params = new URLSearchParams(location.search);
        const code = params.get('code');

        if (code) {
            axiosClient.get(`/github/callback?code=${code}`)
                .then((response) => {
                    localStorage.setItem('token', response.data.data.token);
                    window.location.href = '/dashboard';
                })
                .catch((error) => {
                    console.error('Error handling Github callback:', error);
                });
        } else {
            console.error('Github callback code not found');
        }
    }, [location]);

    return (
        <div>
            <h1>Loading...</h1>
        </div>
    );
};

export default GithubCallback;
