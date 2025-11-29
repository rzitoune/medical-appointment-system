import React, { useState, useEffect } from 'react';
import { useTranslation } from 'react-i18next';
import api from '../../api/axios';

const PatientDashboard = () => {
  const { t } = useTranslation();
  const [activeTab, setActiveTab] = useState('doctors');
  const [doctors, setDoctors] = useState([]);
  const [appointments, setAppointments] = useState([]);
  const [specialization, setSpecialization] = useState('');
  const [loading, setLoading] = useState(true);
  const [showBookingModal, setShowBookingModal] = useState(false);
  const [selectedDoctor, setSelectedDoctor] = useState(null);
  const [bookingData, setBookingData] = useState({
    appointment_date: '',
    appointment_time: '',
    reason: ''
  });
  const [bookingError, setBookingError] = useState('');
  const [bookingSuccess, setBookingSuccess] = useState('');
  const [submitting, setSubmitting] = useState(false);

  useEffect(() => {
    fetchData();
  }, [specialization]);

  const fetchData = async () => {
    setLoading(true);
    try {
      const params = specialization ? { specialization } : {};
      const [doctorsRes, appointmentsRes] = await Promise.all([
        api.get('/doctors', { params }),
        api.get('/patient/appointments').catch(() => ({ data: { data: [] } }))
      ]);
      
      const doctorsData = doctorsRes.data.data || doctorsRes.data.doctors || doctorsRes.data || [];
      const appointmentsData = appointmentsRes.data.data || appointmentsRes.data || [];
      
      setDoctors(Array.isArray(doctorsData) ? doctorsData : []);
      setAppointments(Array.isArray(appointmentsData) ? appointmentsData : []);
    } catch (error) {
      console.error('Error fetching patient data:', error);
      setDoctors([]);
      setAppointments([]);
    } finally {
      setLoading(false);
    }
  };

  const handleBookAppointment = (doctor) => {
    setSelectedDoctor(doctor);
    setShowBookingModal(true);
    setBookingError('');
    setBookingSuccess('');
    setBookingData({ appointment_date: '', appointment_time: '', reason: '' });
  };

  const handleBookingSubmit = async (e) => {
    e.preventDefault();
    setBookingError('');
    setBookingSuccess('');
    
    // Validation
    if (!bookingData.appointment_date || !bookingData.appointment_time) {
      setBookingError('Please select both date and time');
      return;
    }

    const selectedDate = new Date(bookingData.appointment_date);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    if (selectedDate < today) {
      setBookingError('Cannot book appointments in the past');
      return;
    }

    setSubmitting(true);
    try {
      await api.post('/patient/appointments', {
        medical_professional_id: selectedDoctor.id,
        appointment_date: bookingData.appointment_date,
        appointment_time: bookingData.appointment_time,
        reason: bookingData.reason || 'General consultation'
      });
      
      setBookingSuccess('Appointment booked successfully!');
      setTimeout(() => {
        setShowBookingModal(false);
        fetchData(); // Refresh appointments
        setActiveTab('appointments'); // Switch to appointments tab
      }, 1500);
    } catch (error) {
      setBookingError(error.response?.data?.message || 'Failed to book appointment. Please try again.');
    } finally {
      setSubmitting(false);
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

  if (loading) return <div className="spinner"></div>;

  return (
    <div className="dashboard-content fade-in">
      <div className="dashboard-tabs">
        <button 
          className={`tab ${activeTab === 'doctors' ? 'active' : ''}`}
          onClick={() => setActiveTab('doctors')}
        >
          {t('patient.browseDoctors')}
        </button>
        <button 
          className={`tab ${activeTab === 'appointments' ? 'active' : ''}`}
          onClick={() => setActiveTab('appointments')}
        >
          {t('patient.myAppointments')}
        </button>
      </div>

      {activeTab === 'doctors' && (
        <div className="content-section">
          <div className="filters">
            <select 
              value={specialization} 
              onChange={(e) => setSpecialization(e.target.value)}
              className="specialization-select"
            >
              <option value="">{t('patient.allSpecializations')}</option>
              <option value="General Practice">{t('specializations.general')}</option>
              <option value="Cardiology">{t('specializations.cardiology')}</option>
              <option value="Neurology">{t('specializations.neurology')}</option>
              <option value="Pediatrics">{t('specializations.pediatrics')}</option>
              <option value="Dermatology">{t('specializations.dermatology')}</option>
              <option value="ENT">{t('specializations.ent')}</option>
            </select>
          </div>

          <div className="data-grid">
            {doctors.length === 0 ? (
              <p className="empty-state">{t('dashboard.noDoctors')}</p>
            ) : (
              doctors.map(doctor => (
                <div key={doctor.id} className="card professional-card">
                  <div className="professional-header">
                    <h3>Dr. {doctor.user.first_name} {doctor.user.last_name}</h3>
                  </div>
                  <p className="specialization">{doctor.specialization}</p>
                  <div className="doctor-details">
                    <p><strong>{t('dashboard.price')}:</strong> {doctor.consultation_price} MAD</p>
                    <p><strong>{t('dashboard.duration')}:</strong> {doctor.consultation_duration} min</p>
                    {doctor.work_address && <p><strong>{t('dashboard.address')}:</strong> {doctor.work_address}</p>}
                    {doctor.spoken_languages && doctor.spoken_languages.length > 0 && (
                      <p><strong>{t('dashboard.languages')}:</strong> {doctor.spoken_languages.join(', ')}</p>
                    )}
                  </div>
                  <button 
                    className="btn btn-primary btn-block"
                    onClick={() => handleBookAppointment(doctor)}
                  >
                    {t('patient.bookAppointment')}
                  </button>
                </div>
              ))
            )}
          </div>
        </div>
      )}

      {activeTab === 'appointments' && (
        <div className="content-section">
          <h2>{t('patient.myAppointments')}</h2>
          <div className="data-grid">
            {appointments.length === 0 ? (
              <p className="empty-state">{t('dashboard.noAppointments')}</p>
            ) : (
              appointments.map(apt => (
                <div key={apt.id} className="card appointment-card">
                  <div className="appointment-header">
                    <h3>Dr. {apt.medical_professional?.user?.first_name} {apt.medical_professional?.user?.last_name}</h3>
                    <span className="status-badge" style={{ backgroundColor: getStatusColor(apt.status) }}>
                      {apt.status}
                    </span>
                  </div>
                  <p className="specialization">{apt.medical_professional?.specialization}</p>
                  <div className="appointment-details">
                    <p><strong>{t('dashboard.date')}:</strong> {new Date(apt.appointment_date).toLocaleDateString()}</p>
                    <p><strong>Time:</strong> {apt.appointment_time}</p>
                    {apt.reason && <p><strong>Reason:</strong> {apt.reason}</p>}
                  </div>
                </div>
              ))
            )}
          </div>
        </div>
      )}

      {/* Booking Modal */}
      {showBookingModal && selectedDoctor && (
        <div className="modal-overlay" onClick={() => setShowBookingModal(false)}>
          <div className="modal-content card" onClick={(e) => e.stopPropagation()}>
            <h2>Book Appointment</h2>
            <div className="doctor-info-modal">
              <h3>Dr. {selectedDoctor.user.first_name} {selectedDoctor.user.last_name}</h3>
              <p className="specialization">{selectedDoctor.specialization}</p>
              <p><strong>Consultation Fee:</strong> {selectedDoctor.consultation_price} MAD</p>
              <p><strong>Duration:</strong> {selectedDoctor.consultation_duration} minutes</p>
            </div>

            <form onSubmit={handleBookingSubmit}>
              <div className="form-group">
                <label>Appointment Date *</label>
                <input
                  type="date"
                  value={bookingData.appointment_date}
                  onChange={(e) => setBookingData({...bookingData, appointment_date: e.target.value})}
                  min={new Date().toISOString().split('T')[0]}
                  required
                />
              </div>

              <div className="form-group">
                <label>Appointment Time *</label>
                <input
                  type="time"
                  value={bookingData.appointment_time}
                  onChange={(e) => setBookingData({...bookingData, appointment_time: e.target.value})}
                  required
                />
              </div>

              <div className="form-group">
                <label>Reason for Visit (Optional)</label>
                <textarea
                  value={bookingData.reason}
                  onChange={(e) => setBookingData({...bookingData, reason: e.target.value})}
                  placeholder="Describe your symptoms or reason for consultation..."
                  rows="3"
                />
              </div>

              {bookingError && (
                <div className="error-message">
                  <svg viewBox="0 0 20 20" fill="currentColor">
                    <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clipRule="evenodd" />
                  </svg>
                  {bookingError}
                </div>
              )}

              {bookingSuccess && (
                <div className="success-message">
                  <svg viewBox="0 0 20 20" fill="currentColor">
                    <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                  </svg>
                  {bookingSuccess}
                </div>
              )}

              <div className="modal-actions">
                <button 
                  type="button" 
                  className="btn btn-secondary" 
                  onClick={() => setShowBookingModal(false)}
                  disabled={submitting}
                >
                  Cancel
                </button>
                <button 
                  type="submit" 
                  className="btn btn-primary"
                  disabled={submitting}
                >
                  {submitting ? 'Booking...' : 'Confirm Booking'}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};

export default PatientDashboard;
