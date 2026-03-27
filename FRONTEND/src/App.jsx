import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router";
import Login from './pages/Login';
import Dashboard from "./pages/Dashboard";
import CourseDetail from "./pages/CourseDetail";

function App(){
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Navigate to="/login"/>}></Route>
        <Route path="/login" element={<Login />}/>

        <Route path="/dashboard" element={<Dashboard />} />

        <Route path="/courses/:id" element={<CourseDetail />}/>
      </Routes>
    </Router>
  );
}

export default App;