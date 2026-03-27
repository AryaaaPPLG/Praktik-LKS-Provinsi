import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import api from '../api';

export default function Dashboard() {
    const [courses, setCourses] = useState('');
    const [userName, setUserName] = useState('');
    const navigate = useNavigate();

    useEffect(() => {
        const name = localStorage.getItem('user_name');
        if(!name) {
            navigate('/login');
            return;
        }
        setUserName(name);
        fetchCourses();
    }, []);

    const fetchCourses = async () => {
        try {
            const response = await api.get('/courses');
            setCourses(response.data.courses);
        } catch(error) {
            console.error("Gagal Untuk Menarik Data Kursus:", error);
            if(error.response && error.response.status === 401){
                handleLogout();
            }
        }
    };

    const handleLogout = async () => {
        try {
            await api.post('/auth/logout');
        } catch (error) {
            console.error("Anda Sudah Logout Dari Sistem")
        } finally {
            localStorage.removeItem('token');
            localStorage.removeItem('user_name');
            navigate('/login');
        }
    }


return (
        <div style={{ padding: '20px', maxWidth: '800px', margin: 'auto' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                <h2>Halo, {userName}! 👋</h2>
                <button onClick={handleLogout} style={{ padding: '8px 15px', background: 'red', color: 'white', border: 'none', cursor: 'pointer' }}>
                    Logout
                </button>
            </div>

            <hr />
            <h3>Daftar Kursus Tersedia</h3>
            
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(250px, 1fr))', gap: '20px' }}>
                {/* Ini ibarat foreach($courses as $course) di PHP lu */}
                {courses.length > 0 ? (
                    courses.map((course) => (
                        <div key={course.id} style={{ border: '1px solid #ccc', padding: '15px', borderRadius: '8px' }}>
                            <h4>{course.title}</h4>
                            <p style={{ fontSize: '14px', color: '#666' }}>{course.description}</p>
                            <p><strong>Instruktur:</strong> {course.instructor}</p>
                            <p><strong>Harga:</strong> Rp {course.price}</p>
                            <button 
                                onClick={() => navigate(`/courses/${course.id}`)}
                                style={{ width: '100%', padding: '10px', background: 'blue', color: 'white', border: 'none', cursor: 'pointer' }}>
                                Lihat Detail
                            </button>
                        </div>
                    ))
                ) : (
                    <p>Memuat data kursus...</p>
                )}
            </div>
        </div>
    );
}