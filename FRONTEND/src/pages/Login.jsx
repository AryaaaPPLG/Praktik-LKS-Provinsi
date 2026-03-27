import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from '../api';

export default function Login() {
const [email, setEmail] = useState('');
const [password, setPassword] = useState('');
const [errorMsg, setErrorMsg] = useState('');
const navigate = useNavigate(); 

const handleLogin = async (e) => {
    e.preventDefault();
    try {
        const response = await api.post('auth/login',  {
            email: email,
            password: password
        });

        localStorage.setItem('token', response.data.data.token);
        localStorage.setItem('user_name', response.data.data.name);

        alert('Login Berhasil Bro');
        navigate('/dashboard');
    } catch(error) {
        setErrorMsg(error.response.data.message);
    }
}

return (
        <div style={{ padding: '50px', maxWidth: '400px', margin: 'auto' }}>
            <h2>Login Siswa</h2>
            {errorMsg && <p style={{ color: 'red' }}>{errorMsg}</p>}
            
            <form onSubmit={handleLogin}>
                <div style={{ marginBottom: '10px' }}>
                    <label>Email:</label><br/>
                    <input 
                        type="email" 
                        value={email} 
                        onChange={(e) => setEmail(e.target.value)} 
                        required 
                        style={{ width: '100%', padding: '8px' }}
                    />
                </div>
                <div style={{ marginBottom: '10px' }}>
                    <label>Password:</label><br/>
                    <input 
                        type="password" 
                        value={password} 
                        onChange={(e) => setPassword(e.target.value)} 
                        required 
                        style={{ width: '100%', padding: '8px' }}
                    />
                </div>
                <button type="submit" style={{ padding: '10px 20px', cursor: 'pointer' }}>
                    Login
                </button>
            </form>
        </div>
    );
}