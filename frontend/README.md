# Medical System Frontend

A modern React frontend for the Medical System built with Vite.

## 🚀 Features

- **Authentication**: Login and registration for patients and medical professionals
- **Dashboard**: Overview of appointments, medical records, and prescriptions
- **Modern UI**: Dark theme with glassmorphism effects and smooth animations
- **API Integration**: Full integration with Laravel backend
- **Protected Routes**: Authentication-based route protection
- **Responsive Design**: Works on desktop and mobile devices

## 📋 Prerequisites

- Node.js (v16 or higher)
- npm or yarn
- Laravel backend running on http://localhost:8000

## 🛠️ Installation

1. Install dependencies:
```bash
npm install
```

2. Start the development server:
```bash
npm run dev
```

The application will be available at http://localhost:5173

## 🏗️ Project Structure

```
frontend/
├── src/
│   ├── api/
│   │   ├── axios.js          # Axios configuration with interceptors
│   │   └── index.js          # API service layer
│   ├── components/
│   │   └── ProtectedRoute.jsx # Route protection component
│   ├── context/
│   │   └── AuthContext.jsx   # Authentication context
│   ├── pages/
│   │   ├── Login.jsx         # Login page
│   │   ├── Register.jsx      # Registration page
│   │   └── Dashboard.jsx     # Main dashboard
│   ├── App.jsx               # Main app component with routing
│   ├── main.jsx              # React entry point
│   └── index.css             # Global styles
├── index.html                # HTML entry point
├── vite.config.js            # Vite configuration
└── package.json              # Dependencies
```

## 🔌 API Integration

The frontend connects to the Laravel backend at `http://localhost:8000/api`.

### Available Endpoints:

- **Authentication**
  - `POST /api/auth/patient/login`
  - `POST /api/auth/patient/register`
  - `POST /api/auth/professional/login`
  - `POST /api/auth/professional/register`
  - `POST /api/auth/logout`

- **Data**
  - `GET /api/appointments`
  - `GET /api/professionals`
  - `GET /api/records`
  - `GET /api/prescriptions`

## 🎨 Tech Stack

- **React 18** - UI library
- **Vite** - Build tool and dev server
- **React Router** - Client-side routing
- **Axios** - HTTP client
- **Context API** - State management

## 🔒 Authentication

The app uses token-based authentication:
1. User logs in with credentials
2. Backend returns JWT token
3. Token is stored in localStorage
4. Token is sent with every API request via Axios interceptors
5. Protected routes check for valid token

## 🚀 Build for Production

```bash
npm run build
```

The production-ready files will be in the `dist/` directory.

## 📝 Development

To start developing:

1. Make sure the Laravel backend is running
2. Run `npm run dev`
3. Open http://localhost:5173
4. Changes will hot-reload automatically

## 🎯 Next Steps

- Add more features (appointment booking, medical record viewing)
- Implement real-time notifications
- Add more comprehensive error handling
- Implement form validation
- Add loading states for better UX
