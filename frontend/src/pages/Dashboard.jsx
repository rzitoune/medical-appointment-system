import React from 'react';
import { useAuth } from '../context/AuthContext';
import AdminDashboard from './admin/AdminDashboard';
import SecretaryDashboard from './secretary/SecretaryDashboard';
import PatientDashboard from './patient/PatientDashboard';
import ProfessionalDashboard from './professional/ProfessionalDashboard';
import LanguageSwitcher from '../components/LanguageSwitcher';
import { useTranslation } from 'react-i18next';
import { useNavigate } from 'react-router-dom';
import './Dashboard.css';

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
          <div className="medical-logo-small">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" className="nav-icon">
              <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
              <path d="M2 17L12 22L22 17" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
              <path d="M2 12L12 17L22 12" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
            </svg>
          </div>
          <h2 className="health-gradient">{t('app.title')}</h2>
        </div>
        <div className="nav-actions">
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
