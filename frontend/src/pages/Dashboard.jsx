import React from 'react';
import { useAuth } from '../context/AuthContext';
import AdminDashboard from './admin/AdminDashboard';
import SecretaryDashboard from './secretary/SecretaryDashboard';
import PatientDashboard from './patient/PatientDashboard';
import ProfessionalDashboard from './professional/ProfessionalDashboard';
import LanguageSwitcher from '../components/LanguageSwitcher';
import DarkModeToggle from '../components/DarkModeToggle';
import { useTranslation } from 'react-i18next';
import { useNavigate } from 'react-router-dom';
import './Dashboard.css';
import './Dashboard-dark.css';
import './Dashboard-light.css';
import './Dashboard-enhanced.css';


const Dashboard = () => {
  const { user, logout } = useAuth();
  const { t } = useTranslation();
  const navigate = useNavigate();

  const handleLogout = async () => {
    await logout();
    navigate('/login');
  };

  const renderDashboard = () => {
    switch (user?.user_type) {
      case 'administrator':
        return <AdminDashboard />;
      case 'secretary':
        return <SecretaryDashboard />;
      case 'patient':
        return <PatientDashboard />;
      case 'professional':
        return <ProfessionalDashboard />;
      default:
        return <PatientDashboard />;
    }
  };

  return (
    <div className="dashboard-container">
      <nav className="dashboard-nav">
        <div className="nav-brand">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" className="nav-icon">
            <path d="M8 2V5M16 2V5M3.5 9.09H20.5M21 8.5V17C21 20 19.5 22 16 22H8C4.5 22 3 20 3 17V8.5C3 5.5 4.5 3.5 8 3.5H16C19.5 3.5 21 5.5 21 8.5Z" stroke="currentColor" strokeWidth="1.5" strokeMiterlimit="10" strokeLinecap="round" strokeLinejoin="round"/>
            <path d="M15.6947 13.7H15.7037M15.6947 16.7H15.7037M11.9955 13.7H12.0045M11.9955 16.7H12.0045M8.29431 13.7H8.30329M8.29431 16.7H8.30329" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
          </svg>
          <h2 className="health-gradient">{t('app.title')}</h2>
        </div>
        <div className="nav-actions">
          <DarkModeToggle />
          <LanguageSwitcher />
          <div className="nav-user">
            <span>{t('dashboard.welcome')}, {user?.first_name || user?.email}</span>
            <button onClick={handleLogout} className="btn btn-danger btn-sm">
              {t('nav.logout')}
            </button>
          </div>
        </div>
      </nav>

      {renderDashboard()}
    </div>
  );
};

export default Dashboard;
