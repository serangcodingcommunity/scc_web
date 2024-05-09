import { useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../axios";
import { useStateContext } from "../contexts/ContextProvider";
import { FaGithub, FaGoogle} from "react-icons/fa";

const Login = () => {
    const { setCurrentUser, setUserToken } = useStateContext();
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState({ __html: '' });

    const onSubmit = (ev) => {
        ev.preventDefault();
        setError({ __html: '' });

        axiosClient.post('/login', {
            email,
            password,
        })
            .then(({ data }) => {
                setCurrentUser(data.data.user);
                setUserToken(data.data.token);
            })
            .catch((error) => {
                if (error.response) {
                    const finalErrors = Object.values(error.response.data.errors).reduce((accum,
                        next) => [...accum, ...next], []);
                    setError({ __html: finalErrors.join('<br/>') });
                }
                console.log(error)
            });
    };

    return (
        <>
            <div className="flex items-center mt-5">
                <h2 className="text-left text-xl leading-9 tracking-tight text-gray-900 mr-1">
                    Login
                </h2>
                
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-5 h-5">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                </svg>
            </div>

            <span className="text-xs font-semibold">Selamat datang, masuk akun untuk melanjutkan</span>

            {error.__html && (<div className="bg-red-500 rounded py-2 px-3 text-white"
                dangerouslySetInnerHTML={error}>
            </div>)}

            <form onSubmit={onSubmit} className="space-y-2" action="#" method="POST">
                <div className="space-y-5 mx-8">
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
                        Password
                    </label>
                    <div className="mt-2">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autoComplete="current-password"
                            placeholder="********"
                            value={password}
                            onChange={(ev) => setPassword(ev.target.value)}
                            required
                            className="relative block w-full appearance-none rounded-md
                                                    rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 
                                                    placeholder-gray-500 focus:z-10 focus:border-[#142D55]
                                                    focus:outline-none focus:ring-[#142D55] sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>

                <div className="flex items-center justify-between mx-8">
                    <Link
                        to="/register"
                        className="text-xs font-normal hover:font-medium leading-6 text-[#142D55]"
                    >
                        Register
                    </Link>

                    <div className="text-xs">
                        <a
                            href="#"
                            className="font-medium text-[#142D55] hover:font-semibold"
                        >
                            Lupa Password ?
                        </a>
                    </div>
                </div>

                <div className="flex justify-end mr-8">
                    <button
                        type="submit"
                        className="group relative flex justify-center rounded-xl 
                        bg-[#142D55] px-4 text-xs leading-6 text-white shadow-xl 
                            focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 
                        focus-visible:outline-[#142D55] hover:scale-110"
                    >
                        Login
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
        </>
    );
};

export default Login;
