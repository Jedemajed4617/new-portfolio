import React from "react";
import { BrowserRouter as Router, Route, Routes, Navigate } from "react-router-dom";
import Header from './header'; 
import Home from './home'; 
import About from './about'; 
import Footer from './footer';
import Skills from './skills'; 
import Selfmade from './selfmade';
import School from './school';
import Contact from './contact';
import NotFound from './notfound';
import Cv from './cv';
import Other from './other';
import "./App.css";

function App() {
  return (
    <>
      <Router>
        <Header />
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/about" element={<About/>} />
          <Route path="/skills" element={<Skills/>} />
          <Route path="/cv" element={<Cv/>} />
          <Route path="/projects/selfmade" element={<Selfmade/>} />
          <Route path="/projects/school" element={<School/>} />
          <Route path="/projects/other" element={<Other/>} />
          <Route path="/contact" element={<Contact/>} />
          <Route path="*" element={<NotFound />} />
        </Routes>
        <Footer />
      </Router>
    </>
  );
}

export default App;
