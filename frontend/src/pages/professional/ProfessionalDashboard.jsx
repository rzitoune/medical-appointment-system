import React, { useState, useEffect } from 'react';
import { useTranslation } from 'react-i18next';
import api from '../../api/axios';

const ProfessionalDashboard = () => {
  const { t } = useTranslation();
  const [activeTab, setActiveTab] = useState('appointments');
  const [appointments, setAppointments] = useState([]);
  const [loading, setLoading] = useState(true);
  const [stats, setStats] = useState(null);

  useEffect(() => {
    fetchData();
  }, []);

  const fetchData = async () => {
    setLoading(true);
    try {
      const [appointmentsRes, statsRes] = await Promise.all([
        api.get('/professional/appointments').catch(() => ({ data: { data: [] } })),
        api.get('/professional/stats').catch(() => ({ data: { data: {} } }))
      ]);
      
      const appointmentsData = appointmentsRes.data.data || appointmentsRes.data || [];
      setAppointments(Array.isArray(appointmentsData) ? appointmentsData : []);
      setStats(statsRes.data.data || statsRes.data || {});
    } catch (error) {
      console.error('Error fetching professional data:', error);
      setAppointments([]);
    } finally {
      setLoading(false);
    }
  };

  const handleStatusChange = async (appointmentId, newStatus) => {
    try {
      await api.put(`/professional/appointments/${appointmentId}`, { status: newStatus });
      fetchData(); // Refresh data
    } catch (error) {
      console.error('Error updating appointment status:', error);
    }
  };

  const getStatusColor = (status) => {
    switch(status?.toLowerCase()) {
      case 'confirmed': return '#10b981';
      case 'pending': return '#f59e0b';
      case 'cancelled': return '#ef4444';
      case 'completed': return '#06b6d4';
      default: return '#64748b';
    }
  };

  const filterAppointments = (filter) => {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    return appointments.filter(apt => {
      const aptDate = new Date(apt.appointment_date);
      aptDate.setHours(0, 0, 0, 0);
      
      switch(filter) {
        case 'today':
          return aptDate.getTime() === today.getTime();
        case 'upcoming':
          return aptDate >= today;
        case 'past':
          return aptDate < today;
        default:
          return true;
      }
    });
  };

  if (loading) return <div className="spinner"></div>;

  const todayAppointments = filterAppointments('today');
  const upcomingAppointments = filterAppointments('upcoming');

  return (
    <div className="dashboard-content fade-in">
      {/* Stats Overview */}
      <div className="overview-grid">
        <div className="stat-card card">
          <h3>Today's Appointments</h3>
          <p className="stat-number">{todayAppointments.length}</p>
        </div>
        <div className="stat-card card">
          <h3>Upcoming Appointments</h3>
          <p className="stat-number">{upcomingAppointments.length}</p>
        </div>
        <div className="stat-card card">
          <h3>Total Patients</h3>
          <p className="stat-number">{stats.total_patients || 0}</p>
        </div>
      </div>

      {/* Tabs */}
      <div className="dashboard-tabs">
        <button 
          className={`tab ${activeTab === 'appointments' ? 'active' : ''}`}
          onClick={() => setActiveTab('appointments')}
        >
          All Appointments
        </button>
        <button 
          className={`tab ${activeTab === 'today' ? 'active' : ''}`}
          onClick={() => setActiveTab('today')}
        >
          Today
        </button>
        <button 
          className={`tab ${activeTab === 'upcoming' ? 'active' : ''}`}
          onClick={() => setActiveTab('upcoming')}
        >
          Upcoming
        </button>
      </div>

      {/* Appointments List */}
      <div className="content-section">
        <div className="data-grid">
          {(activeTab === 'appointments' ? appointments :
            activeTab === 'today' ? todayAppointments :
            upcomingAppointments).length === 0 ? (
            <p className="empty-state">No appointments found</p>
          ) : (
            (activeTab === 'appointments' ? appointments :
              activeTab === 'today' ? todayAppointments :
              upcomingAppointments).map(apt => (
              <div key={apt.id} className="card appointment-card">
                <div className="appointment-header">
                  <div>
                    <h3>{apt.patient?.user?.first_name} {apt.patient?.user?.last_name}</h3>
                    <p style={{ color: 'rgba(255, 255, 255, 0.6)', fontSize: '13px', margin: '4px 0 0 0' }}>
                      {apt.patient?.user?.email}
                    </p>
                  </div>
                  <span className="status-badge" style={{ backgroundColor: getStatusColor(apt.status) }}>
                    {apt.status}
                  </span>
                </div>
                
                <div className="appointment-details">
                  <p><strong>Date:</strong> {new Date(apt.appointment_date).toLocaleDateString()}</p>
                  <p><strong>Time:</strong> {apt.appointment_time}</p>
                  {apt.reason && <p><strong>Reason:</strong> {apt.reason}</p>}
                  {apt.patient?.user?.phone && <p><strong>Phone:</strong> {apt.patient?.user?.phone}</p>}
                </div>

                {apt.status === 'pending' && (
                  <div className="appointment-actions">
                    <button 
                      className="btn btn-primary btn-sm"
                      onClick={() => handleStatusChange(apt.id, 'confirmed')}
                    >
                      Confirm
                    </button>
                    <button 
                      className="btn btn-danger btn-sm"
                      onClick={() => handleStatusChange(apt.id, 'cancelled')}
                    >
                      Cancel
                    </button>
                  </div>
                )}

                {apt.status === 'confirmed' && (
                  <div className="appointment-actions">
                    <button 
                      className="btn btn-primary btn-sm"
                      onClick={() => handleStatusChange(apt.id, 'completed')}
                    >
                      Mark as Completed
                    </button>
                  </div>
                )}
              </div>
            ))
          )}
        </div>
      </div>
    </div>
  );
};

export default ProfessionalDashboard;
