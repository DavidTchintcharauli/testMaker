import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function TeacherDashboard({ auth }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">ეს არის ზედა დეშბორდის ნაწილი</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h1>თქვენ შესული ხართ დეშბორდზე</h1>
                            <h1>თქვენ იმყოფებით მასწავლებელთა საინფორმაციო დაფაზე</h1>
                            <p>მოგესალმებით, მასწავლებელთა! აქ ნახავთ თქვენს ყველა რესურსსა და ინფორმაციას.</p>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
