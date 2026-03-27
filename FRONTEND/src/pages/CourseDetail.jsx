import { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import api from '../api';

export default function CourseDetail () {
    const { id } = useParams();
    const navigate = useNavigate();

    const [course, setCourse] = useState(null);
    const [notes, setNotes] = useState('');
    const [statusMsg, setStatusMsg] = useState('');

    useEffect(() => {
        fetchCourseDetail();
    }, []);

    const fetchCourseDetail = async () => {
        try {
            const response = await api.get(`/courses/${id}`);
            setCourse(response.data.course);
        } catch (error) {
            console.error("Gagal Narik Data Detail", error);
            alert('Kursus Tidak Ditemukan!');
            navigate('/dashboard');
        }
    };

    const handleEnroll = async (e) => {
        e.preventDefault();
        try {
            const response = await api.post('/enrollments', {
                course_id: id,
                notes: notes
            });

            setStatusMsg(response.data.message);
            setNotes('');
        } catch (error) {
            if (error.response) {
                setStatusMsg(error.response.data.message);
            }
        }
    };

if (!course) return <h2 style={{ textAlign: 'center', marginTop: '50px' }}>Loading data kursus...</h2>;

return (
        <div style={{ padding: '20px', maxWidth: '800px', margin: 'auto' }}>
            <button onClick={() => navigate('/dashboard')} style={{ marginBottom: '20px', padding: '5px 10px', cursor: 'pointer' }}>
                ⬅ Kembali ke Dashboard
            </button>

            <div style={{ border: '1px solid #ccc', padding: '20px', borderRadius: '8px' }}>
                <h2>{course.title}</h2>
                <p><strong>Instruktur:</strong> {course.instructor}</p>
                <p><strong>Harga:</strong> Rp {course.price}</p>
                <p>{course.description}</p>
                
                <hr />
                
                <h3>Materi Pembelajaran</h3>
                <ul>
                    {/* Looping materi kursusnya [cite: 304] */}
                    {course.materials && course.materials.length > 0 ? (
                        course.materials.map((materi) => (
                            <li key={materi.id}>
                                {materi.title} - <a href="#">Lihat Video</a>
                            </li>
                        ))
                    ) : (
                        <p>Belum ada materi untuk kursus ini.</p>
                    )}
                </ul>
            </div>

            <div style={{ marginTop: '30px', padding: '20px', background: '#f9f9f9', borderRadius: '8px', color: 'black' }}>
                <h3>Daftar Kursus Ini</h3>
                {statusMsg && (
                    <div style={{ padding: '10px', marginBottom: '10px', background: statusMsg.includes('berhasil') ? '#d4edda' : '#f8d7da', color: 'black', borderRadius: '5px' }}>
                        {statusMsg}
                    </div>
                )}
                
                <form onSubmit={handleEnroll}>
                    <label>Catatan Pendaftaran:</label><br />
                    <textarea 
                        value={notes}
                        onChange={(e) => setNotes(e.target.value)}
                        placeholder="Contoh: Saya ingin belajar dari nol..."
                        required
                        style={{ width: '100%', height: '80px', padding: '10px', marginTop: '10px' }}
                    /><br /><br />
                    <button type="submit" style={{ padding: '10px 20px', background: 'green', color: 'white', border: 'none', cursor: 'pointer', width: '100%' }}>
                        Kirim Pendaftaran
                    </button>
                </form>
            </div>
        </div>
    );
}