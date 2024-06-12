import React, { useState, useEffect } from 'react';
import { Inertia } from '@inertiajs/inertia';

function RoleSelection({ teachers }) {
    const [role, setRole] = useState('');
    const [teacherId, setTeacherId] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();

        Inertia.post(route('role.selection'), {
            role,
            teacher_id: role === 'student' ? teacherId : null,
        });
    };

    return (
        <div>
            <h1>Select Your Role</h1>
            <form onSubmit={handleSubmit}>
                <label>
                    <input
                        type="radio"
                        value="teacher"
                        checked={role === 'teacher'}
                        onChange={() => setRole('teacher')}
                    />
                    Teacher
                </label>
                <label>
                    <input
                        type="radio"
                        value="student"
                        checked={role === 'student'}
                        onChange={() => setRole('student')}
                    />
                    Student
                </label>
                <label>
                    <input
                        type="radio"
                        value="guest"
                        checked={role === 'guest'}
                        onChange={() => setRole('guest')}
                    />
                    Guest
                </label>
                {role === 'student' && (
                    <div>
                        <label>Choose Your Teacher</label>
                        <select
                            value={teacherId}
                            onChange={(e) => setTeacherId(e.target.value)}
                        >
                            <option value="">Select a teacher</option>
                            {teachers.map((teacher) => (
                                <option key={teacher.id} value={teacher.id}>
                                    {teacher.name}
                                </option>
                            ))}
                        </select>
                    </div>
                )}
                <button type="submit">Submit</button>
            </form>
        </div>
    );
}

export default RoleSelection;
