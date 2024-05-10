import { Link } from "react-router-dom";
import axiosClient from "../../axios";
import { useState } from "react";
import { useStateContext } from "../../contexts/ContextProvider";
import { FaGithub, FaGoogle } from "react-icons/fa";

const Register = () => {
    const { setCurrentUser, setUserToken } = useStateContext();
    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [passwordConfirmation, setPasswordConfirmation] = useState("");
    const [error, setError] = useState({ __html: '' });

    const onSubmit = (ev) => {
        ev.preventDefault();
        setError({ __html: '' });

        axiosClient.post('/register', {
            name,
            email,
            password,
            password_confirmation: passwordConfirmation
        })
            .then(({ data }) => {
                setCurrentUser(data.data.user);
                setUserToken(data.data.token);
            })
            .catch((error) => {
                if (error.response) {
                    const finalErrors = Object.values(error.response.data.errors).reduce((accum,
                        next) => [...accum, ...next], []);
                    console.log(finalErrors);
                    setError({ __html: finalErrors.join('<br/>') });
                }
                console.log(error)
            });
    };

    return (
        <>
            <div className="mt-20 sm:mx-auto sm:w-full sm:max-w-sm rounded-lg p-5 shadow-xl border-2 border-slate-50 relative bg-white">
                <span className="absolute top-0 left-1/2 transform -translate-x-1/2 w-1/4 h-4 rounded-md bg-[#142D55]"></span>


                <h2 className="text-left text-xl leading-9 tracking-tight text-gray-900 mr-1">
                    Register
                </h2>

                <span className="text-xs font-semibold">Selamat datang, daftar akun untuk melanjutkan</span>

                {error.__html && (<div className="bg-red-500 rounded py-2 px-3 text-white"
                    dangerouslySetInnerHTML={error}>
                </div>)}

                <form onSubmit={onSubmit} className="space-y-2" action="#" method="POST">
                    <div className="space-y-5 mx-8">
                        <label
                            htmlFor="name"
                            className="sr-only"
                        >
                        </label>
                        <div className="mt-2">
                            <input
                                id="name"
                                name="name"
                                type="text"
                                autoComplete="email"
                                placeholder="Masukan nama lengkap"
                                required
                                value={name}
                                onChange={(ev) => setName(ev.target.value)}
                                className="relative block w-full appearance-none rounded-md
                                        rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 
                                        placeholder-gray-500 focus:z-10 focus:border-[#142D55]
                                        focus:outline-none focus:ring-[#142D55] sm:text-sm sm:leading-6"
                            />
                        </div>
                    </div>

                    <div className="mx-8">
                        <label
                            htmlFor="email"
                            className="sr-only"
                        >
                        </label>
                        <div className="mt-2">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autoComplete="email"
                                placeholder="example@email.com"
                                required
                                value={email}
                                onChange={(ev) => setEmail(ev.target.value)}
                                className="relative block w-full appearance-none rounded-md
                                                    rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 
                                                    placeholder-gray-500 focus:z-10 focus:border-[#142D55]
                                                    focus:outline-none focus:ring-[#142D55] sm:text-sm sm:leading-6"
                            />
                        </div>
                    </div>

                    <div className="mx-8">
                        <label
                            htmlFor="password"
                            className="sr-only"
                        >
                        </label>
                        <div className="mt-2">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autoComplete="current-password"
                                placeholder="********"
                                required
                                value={password}
                                onChange={(ev) => setPassword(ev.target.value)}
                                className="relative block w-full appearance-none rounded-md
                                                    rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 
                                                    placeholder-gray-500 focus:z-10 focus:border-[#142D55]
                                                    focus:outline-none focus:ring-[#142D55] sm:text-sm sm:leading-6"
                            />
                        </div>
                    </div>

                    <div className="mx-8">
                        <label
                            htmlFor="password-confirmation"
                            className="sr-only"
                        >
                        </label>
                        <div className="mt-2">
                            <input
                                id="password-confirmation"
                                name="password_confirmation"
                                type="password"
                                placeholder="********"
                                required
                                value={passwordConfirmation}
                                onChange={(ev) => setPasswordConfirmation(ev.target.value)}
                                className="relative block w-full appearance-none rounded-md
                                                rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 
                                                placeholder-gray-500 focus:z-10 focus:border-[#142D55]
                                                focus:outline-none focus:ring-[#142D55] sm:text-sm sm:leading-6"
                            />
                        </div>
                    </div>

                    <div className="flex items-center justify-between mx-8">
                        <Link
                            to="/login"
                            className="text-xs font-normal hover:font-medium leading-6 text-[#142D55]"
                        >
                            Login
                        </Link>

                        <button
                            type="submit"
                            className="group relative flex justify-center rounded-xl 
                        bg-[#142D55] px-4 text-xs leading-6 text-white shadow-xl 
                            focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 
                        focus-visible:outline-[#142D55] hover:scale-110"
                        >
                            Register
                        </button>
                    </div>
                </form>

                <p className="mt-2 text-center text-xs text-gray-500">
                    <span className="font-bold text-xl text-center">_</span> Or Login With <span className="font-bold text-xl text-center">_</span>
                </p>

                <div className="flex justify-center space-x-4 mt-2">
                    <button className="bg-white text-black border border-black rounded-lg flex items-center text-xs p-1 hover:scale-110">
                        <FaGoogle className="h-3 w-3 mr-2" />
                        Google
                    </button>
                    <button className="bg-white text-black border border-black rounded-lg flex items-center text-xs p-1 hover:scale-110">
                        <FaGithub className="h-3 w-3 mr-2" />
                        GitHub
                    </button>
                </div>
            </div>
        </>
    );
};

export default Register;
