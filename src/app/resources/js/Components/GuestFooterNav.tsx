import { Link } from '@inertiajs/react';

interface Props {
  routes: {
    current: string;
    home: string;
    login: string;
  };
}

export default function GuestLayout({ routes }: Props) {
  var route = routes.login;
  var route_name = 'ログイン';

  if (routes.current == routes.login) {
    route = routes.home;
    route_name = 'ホーム';
  }

  return (
    <div className="bg-gray-50 text-gray-800">
      <nav className="flex items-center justify-between px-4 py-3 bg-white shadow fixed top-0 w-full z-50">
        <Link href="/" className="flex items-center gap-2">
          <img src="/images/logo.png" alt="OLDWS" className="h-8 w-8" />
          <span className="font-bold text-blue-700 text-sm">OLDWS</span>
        </Link>
      </nav>

      <nav className="fixed bottom-0 left-0 right-0 bg-white border-t shadow-md z-50 sm:hidden">
        <div className="flex justify-center py-2">
          <Link
            href={route}
            className="flex flex-col items-center text-blue-600 hover:text-blue-800"
          >
            <svg
              className="w-7 h-7 mb-1"
              fill="none"
              stroke="currentColor"
              strokeWidth="2"
              viewBox="0 0 24 24"
            >
              <path strokeLinecap="round" strokeLinejoin="round" d="M15 12H3m6-6l-6 6 6 6" />
            </svg>
            <span className="text-xs font-semibold">{route_name}</span>
          </Link>
        </div>
      </nav>
    </div>
  );
}
