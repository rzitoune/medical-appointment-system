import React, { useState, useEffect } from 'react';
import { useTranslation } from 'react-i18next';
import api from '../../api/axios';

const SecretaryDashboard = () => {
  const { t } = useTranslation();
  const [appointments, setAppointments] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchAppointments();
  }, []);

  const fetchAppointments = async () => {
    try {
      const response = await api.get('/secretary/appointments');
      setAppointments(response.data.data || []);
    } catch (error) {
      console.error('Error fetching appointments:', error);
    } finally {
      setLoading(false);
    }
  };

  if (loading) return <div className="spinner"></div>;

  return (
    <div className="dashboard-content fade-in">
      <div className="section-header">
        <h2>{t('secretary.appointmentList')}</h2>
        <button className="btn btn-primary">
          {t('secretary.createAppointment')}
        </button>
      </div>

      <div className="data-grid">
        {appointments.length === 0 ? (
          <p className="empty-state">{t('dashboard.noAppointments')}</p>
        ) : (
          appointments.map(apt => (
            <div key={apt.id} className="card">
              <h3>{t('dashboard.appointmentNumber')}{apt.id}</h3>
              <p>{t('dashboard.date')}: {apt.appointment_date}</p>
              <p>{t('dashboard.status')}: {apt.status}</p>
            </div>
          ))
        )}
      </div>
    </div>
  );
};

export default SecretaryDashboard;
