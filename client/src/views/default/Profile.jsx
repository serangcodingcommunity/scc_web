// Profile.jsx
import React, { useEffect, useState } from 'react';
import axiosClient from '../../axios.js';
import PageComponent from '../../components/PageComponent.jsx';
import { useParams } from 'react-router-dom';
import { photoStorageUrl } from '../../config.js';

const Profile = () => {
    const { id } = useParams();

    const [user, setUser] = useState({
        name: '',
        email: '',
        profile_photo_path: null,
        image_url: null,
    });
    const [loading, setLoading] = useState(false);

    const onImageChoose = (ev) => {
        const file = ev.target.files[0];
        const reader = new FileReader();

        reader.onload = () => {
            setUser((prevUser) => ({
                ...prevUser,
                profile_photo_path: file,
                image_url: reader.result,
            }));
            ev.target.value = '';
        };

        reader.readAsDataURL(file);
    };

    const onSubmit = (ev) => {
        ev.preventDefault();

        const formData = new FormData();
        formData.append('profile_photo_path', user.profile_photo_path);

        axiosClient
            .post(`/users/upload`, formData)
            .then(({ data }) => {
                setUser((prevUser) => ({
                    ...prevUser,
                    image_url: data.image_url,
                }));
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    };

    useEffect(() => {
        if (id) {
            setLoading(true);
            axiosClient.get(`/users/${id}`).then(({ data }) => {
                setUser(data.data);
                setLoading(false);
            });
        }
    }, [id]);

    return (
        <PageComponent title="Profile">
            <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3">
                <form action="#" method="POST" onSubmit={onSubmit}>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Photo</label>
                        <div className="mt-1 flex items-center">
                            {user.profile_photo_path && (
                                <img
                                    src={photoStorageUrl + 'profile/' + user.profile_photo_path}
                                    alt=""
                                    className="w-32 h-32 object-cover"
                                />
                            )}

                            {user.image_url && (
                                <img src={user.image_url} alt="" className="w-32 h-32 object-cover" />
                            )}

                            <button className="relative ml-5 rounded-md border border-gray-300 bg-white py-2 px-3 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <input
                                    type="file"
                                    className="absolute left-0 top-0 right-0 bottom-0 opacity-0"
                                    onChange={onImageChoose}
                                />
                                Change
                            </button>
                        </div>
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700">Name</label>
                        <div className="mt-1">
                            <input
                                type="text"
                                value={user.name}
                                readOnly
                                className="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"
                            />
                        </div>
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700">Email</label>
                        <div className="mt-1">
                            <input
                                type="email"
                                value={user.email}
                                readOnly
                                className="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"
                            />
                        </div>
                    </div>

                    <div className="mt-6">
                        <button
                            type="submit"
                            className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Save
                        </button>
                    </div>
                    
                </form>
            </div>
        </PageComponent>
    );
};

export default Profile;
