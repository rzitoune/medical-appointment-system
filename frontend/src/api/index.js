import api from './axios';

export const authAPI = {
  // Patient authentication
  patientRegister: (data) => api.post('/auth/patient/register', data),
  patientLogin: (data) => api.post('/auth/patient/login', data),
  
  // Professional authentication
  professionalRegister: (data) => api.post('/auth/professional/register', data),
  professionalLogin: (data) => api.post('/auth/professional/login', data),

  // Admin authentication
  adminLogin: (data) => api.post('/auth/admin/login', data),

  // Secretary authentication
  secretaryLogin: (data) => api.post('/auth/secretary/login', data),
  
  // Common
  logout: () => api.post('/auth/logout'),
  getCurrentUser: () => api.get('/auth/me'),
};

export const professionalAPI = {
  getAll: () => api.get('/professionals'),
  getById: (id) => api.get(`/professionals/${id}`),
};

export const appointmentAPI = {
  getAll: () => api.get('/appointments'),
  create: (data) => api.post('/appointments', data),
  getById: (id) => api.get(`/appointments/${id}`),
  update: (id, data) => api.put(`/appointments/${id}`, data),
  delete: (id) => api.delete(`/appointments/${id}`),
};

export const medicalRecordAPI = {
  getAll: () => api.get('/records'),
  getById: (id) => api.get(`/records/${id}`),
};

export const prescriptionAPI = {
  getAll: () => api.get('/prescriptions'),
  getById: (id) => api.get(`/prescriptions/${id}`),
};

export const availabilityAPI = {
  getAll: () => api.get('/availability'),
  getByProfessional: (professionalId) => api.get(`/availability/${professionalId}`),
};
