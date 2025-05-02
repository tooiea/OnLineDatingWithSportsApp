import { LogIn } from 'lucide-react';
import { Link } from '@inertiajs/react';

interface Props {
  routes: {
    current: string;
    home: string;
    login: string;
  };
}

export default function AuthenticatedFooterNav({ routes }: Props) {
  const isActive = (routeName: keyof typeof routes) => {
    return routes.current === routes[routeName];
  };

  const navItems = [
    { href: routes.login, label: 'ログイン', icon: <LogIn size={20} />, routeKey: 'login' },
  ];

  return (
    <nav className="fixed bottom-0 left-0 right-0 bg-white border-t shadow sm:hidden z-50">
      <div className="flex justify-around">
        {navItems.map((item) => (
          <Link
            key={item.label}
            href={item.href}
            className={`flex flex-col items-center justify-center flex-1 py-2 text-xs ${
              isActive(item.routeKey as keyof typeof routes) ? 'text-indigo-600' : 'text-gray-500'
            }`}
          >
            {item.icon}
            <span>{item.label}</span>
          </Link>
        ))}
      </div>
    </nav>
  );
}
