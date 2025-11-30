import React, { useState, useEffect } from 'react';
import { useTranslation } from 'react-i18next';
import api from '../../api/axios';

const AdminDashboard = () => {
  const { t } = useTranslation();
  const [activeTab, setActiveTab] = useState('doctors');
  const [doctors, setDoctors] = useState([]);
  const [stats, setStats] = useState(null);
  const [loading, setLoading] = useState(true);
  const [showModal, setShowModal] = useState(false);
  const [editingDoctor, setEditingDoctor] = useState(null);
  const [formData, setFormData] = useState({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    phone: '',
    address: '',
    specialization: 'General Practice',
    rpps_number: '',
    qualifications: '',
    work_address: '',
    consultation_duration: 30,
    consultation_price: 0,
    is_teleconsultation_available: false,
    spoken_languages: ['French', 'Arabic'],
    accepted_insurance: ['CNSS']
  });

  useEffect(() => {
    fetchData();
  }, []);

  const fetchData = async () => {
    try {
      const [doctorsRes, statsRes] = await Promise.all([
        api.get('/admin/doctors'),
        api.get('/admin/stats')
      ]);
      setDoctors(doctorsRes.data.data);
      setStats(statsRes.data.data);
    } catch (error) {
      console.error('Error fetching admin data:', error);
    } finally {
      setLoading(false);
    }
  };

  const handleInputChange = (e) => {
    const { name, value, type, checked } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: type === 'checkbox' ? checked : value
    }));
  };

  const handleAddDoctor = () => {
    setEditingDoctor(null);
    setFormData({
      first_name: '', last_name: '', email: '', password: '', phone: '', address: '',
      specialization: 'General Practice', rpps_number: '', qualifications: '',
      work_address: '', consultation_duration: 30, consultation_price: 0,
      is_teleconsultation_available: false, spoken_languages: ['French', 'Arabic'],
      accepted_insurance: ['CNSS']
    });
    setShowModal(true);
  };

  const handleEditDoctor = (doctor) => {
    setEditingDoctor(doctor);
    setFormData({
      first_name: doctor.user.first_name,
      last_name: doctor.user.last_name,
      email: doctor.user.email,
      password: '',  // Don't pre-fill password
      phone: doctor.user.phone,
      address: doctor.user.address,
      specialization: doctor.specialization,
      rpps_number: doctor.rpps_number,
      qualifications: doctor.qualifications,
      work_address: doctor.work_address,
      consultation_duration: doctor.consultation_duration,
      consultation_price: doctor.consultation_price,
      is_teleconsultation_available: doctor.is_teleconsultation_available,
      spoken_languages: doctor.spoken_languages || ['French', 'Arabic'],
      accepted_insurance: doctor.accepted_insurance || ['CNSS']
    });
    setShowModal(true);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      if (editingDoctor) {
        // Update existing doctor
        const updateData = { ...formData };
        if (!updateData.password) {
          delete updateData.password; // Don't send empty password
        }
        await api.put(`/admin/doctors/${editingDoctor.id}`, updateData);
      } else {
        // Create new doctor
        await api.post('/admin/doctors', formData);
      }
      setShowModal(false);
      fetchData();
    } catch (error) {
      console.error('Error saving doctor:', error);
      alert(error.response?.data?.message || 'Failed to save doctor');
    }
  };

  const handleDelete = async (id) => {
    if (window.confirm(t('admin.confirmDelete'))) {
      try {
        await api.delete(`/admin/doctors/${id}`);
        fetchData();
      } catch (error) {
        console.error('Error deleting doctor:', error);
      }
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
          {t('admin.doctorList')}
        </button>
        <button 
          className={`tab ${activeTab === 'stats' ? 'active' : ''}`}
          onClick={() => setActiveTab('stats')}
        >
          {t('nav.statistics')}
        </button>
      </div>

      {activeTab === 'stats' && stats && (
        <div className="overview-grid">
          <div className="stat-card card">
            <h3>{t('admin.totalDoctors')}</h3>
            <p className="stat-number">{stats.total_doctors}</p>
          </div>
          <div className="stat-card card">
            <h3>{t('admin.totalPatients')}</h3>
            <p className="stat-number">{stats.total_patients}</p>
          </div>
          <div className="stat-card card">
            <h3>{t('admin.totalAppointments')}</h3>
            <p className="stat-number">{stats.total_appointments}</p>
          </div>
        </div>
      )}

      {activeTab === 'doctors' && (
        <div className="content-section">
          <div className="section-header">
            <h2>{t('admin.doctorList')}</h2>
            <button className="btn btn-primary" onClick={handleAddDoctor}>
              {t('admin.addDoctor')}
            </button>
          </div>

          <div className="data-grid">
            {doctors.map(doctor => (
              <div key={doctor.id} className="card professional-card">
                <div className="professional-header">
                  <h3>Dr. {doctor.user.first_name} {doctor.user.last_name}</h3>
                  <div className="action-buttons">
                    <button 
                      className="btn btn-primary btn-sm"
                      onClick={() => handleEditDoctor(doctor)}
                    >
                      {t('common.edit')}
                    </button>
                    <button 
                      className="btn btn-danger btn-sm"
                      onClick={() => handleDelete(doctor.id)}
                    >
                      {t('common.delete')}
                    </button>
                  </div>
                </div>
                <p className="specialization">{doctor.specialization}</p>
                <div className="doctor-details-block">
                  <p>{doctor.user.email}</p>
                  <p>{doctor.user.phone}</p>
                </div>
                <p className="price">{doctor.consultation_price} MAD</p>
              </div>
            ))}
          </div>
        </div>
      )}

      {showModal && (
        <div className="modal-overlay">
          <div className="modal-content card" style={{ maxHeight: '90vh', overflowY: 'auto' }}>
            <h2>{editingDoctor ? t('common.edit') + ' ' + t('admin.doctor') : t('admin.addDoctor')}</h2>
            <form onSubmit={handleSubmit}>
              <div className="form-row">
                <div className="form-group">
                  <label>{t('auth.firstName')}</label>
                  <input name="first_name" value={formData.first_name} onChange={handleInputChange} required />
                </div>
                <div className="form-group">
                  <label>{t('auth.lastName')}</label>
                  <input name="last_name" value={formData.last_name} onChange={handleInputChange} required />
                </div>
              </div>
              
              <div className="form-row">
                <div className="form-group">
                  <label>{t('auth.email')}</label>
                  <input type="email" name="email" value={formData.email} onChange={handleInputChange} required />
                </div>
                <div className="form-group">
                  <label>{t('auth.password')} {editingDoctor && '(' + t('dashboard.leaveBlankPassword') + ')'}</label>
                  <input 
                    type="password" 
                    name="password" 
                    value={formData.password} 
                    onChange={handleInputChange} 
                    required={!editingDoctor}
                    placeholder={editingDoctor ? "Leave blank to keep current password" : ""}
                  />
                </div>
              </div>

              <div className="form-row">
                <div className="form-group">
                  <label>{t('auth.phone')}</label>
                  <input name="phone" value={formData.phone} onChange={handleInputChange} required />
                </div>
                <div className="form-group">
                  <label>{t('dashboard.specialization')}</label>
                  <select name="specialization" value={formData.specialization} onChange={handleInputChange}>
                    <option value="General Practice">General Practice</option>
                    <option value="Cardiology">Cardiology</option>
                    <option value="Neurology">Neurology</option>
                    <option value="Pediatrics">Pediatrics</option>
                    <option value="Dermatology">Dermatology</option>
                    <option value="ENT">ENT</option>
                  </select>
                </div>
              </div>

              <div className="form-group">
                <label>{t('dashboard.address')}</label>
                <input name="address" value={formData.address} onChange={handleInputChange} required />
              </div>

              <div className="form-row">
                <div className="form-group">
                  <label>{t('dashboard.rppsNumber')}</label>
                  <input name="rpps_number" value={formData.rpps_number} onChange={handleInputChange} required />
                </div>
                <div className="form-group">
                  <label>{t('dashboard.price')}</label>
                  <input type="number" name="consultation_price" value={formData.consultation_price} onChange={handleInputChange} required />
                </div>
              </div>

              <div className="form-group">
                <label>{t('dashboard.qualifications')}</label>
                <textarea name="qualifications" value={formData.qualifications} onChange={handleInputChange} required />
              </div>

              <div className="form-group">
                <label>{t('dashboard.workAddress')}</label>
                <input name="work_address" value={formData.work_address} onChange={handleInputChange} required />
              </div>

              <div className="form-group">
                <label>
                  <input 
                    type="checkbox" 
                    name="is_teleconsultation_available" 
                    checked={formData.is_teleconsultation_available} 
                    onChange={handleInputChange} 
                  />
                  {' '}{t('dashboard.teleconsultation')}
                </label>
              </div>

              <div className="modal-actions">
                <button type="button" className="btn btn-secondary" onClick={() => setShowModal(false)}>
                  {t('common.cancel')}
                </button>
                <button type="submit" className="btn btn-primary">
                  {t('common.save')}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};

export default AdminDashboard;
