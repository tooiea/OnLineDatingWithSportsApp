import GuestFooterNav from '@/Components/GuestFooterNav';
import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import { PropsWithChildren } from 'react';

interface Props extends PropsWithChildren {
  routes: {
    current: string;
    home: string;
    login: string;
  };
}

export default function GuestLayout({ children, routes }: Props) {
  return (
    <div className="flex flex-col min-h-screen bg-gray-100">

      <main className="flex-grow flex justify-center items-start pt-32 pb-20 sm:pt-20">
        <div className="w-full max-w-md rounded-2xl bg-white px-6 py-6 shadow-md">
          {children}
        </div>
      </main>

      <GuestFooterNav routes={routes} />
    </div>
  );
}
