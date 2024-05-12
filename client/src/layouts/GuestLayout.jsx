import { Navigate, Outlet, useNavigate } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";
import blobLight from "../assets/blob/blobLight.svg";
import blobDark from "../assets/blob/blobDark.svg";

export default function GuestLayout() {
    const { token, darkMode, toggleDarkMode} = useStateContext();
    const navigate = useNavigate();

    if (token) {
        return navigate('/dashboard');
    }

    return (
        <>
            <div className="fixed inset-0 flex items-center justify-center bg-opacity-50">
                <div className="text-center">
                    <img src={`${darkMode ? blobDark : blobLight}`}  alt="Blob Light" className="max-w-full max-h-full" />
                </div>
            </div>
            <Outlet />
        </>
    );
}
