import React from "react";
import { HashRouter as Router, Route, Routes } from "react-router-dom";
import Header from './header'; 
import Home from './home'; 
import About from './about'; 
import Footer from './footer';
import Skills from './skills'; 
import Selfmade from './selfmade';
import School from './school';
import Contact from './contact';
import "./App.css";

function App() {
  return (
      <>
        <Router>
          <Header />
          <Routes>
            <Route path="/" element={<Home/>} />
            <Route path="/about" element={<About/>} />
            <Route path="/skills" element={<Skills/>} />
            <Route path="/selfmade" element={<Selfmade/>} />
            <Route path="/school" element={<School/>} />
            <Route path="/contact" element={<Contact/>} />
          </Routes>
          <Footer />
        </Router>
      </>
  );
}

export default App;