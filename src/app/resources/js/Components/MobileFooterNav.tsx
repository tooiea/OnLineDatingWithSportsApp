import { Home, Search, Users, User, Contact } from 'lucide-react';
import { Link, usePage } from '@inertiajs/react';

export default function MobileFooterNav() {
  const currentUrl = usePage().url;

  const isActive = (path: string) => currentUrl === path;

  const navItems = [
    { href: route('home'), label: 'ホーム', icon: <Home size={20} /> },
    { href: route('myteam.index'), label: '招待情報', icon: <Contact size={20} /> },
    { href: route('team.list'), label: '検索', icon: <Search size={20} /> },
    { href: route('myteam.detail'), label: 'チーム情報', icon: <Users size={20} /> },
    { href: route('my-profile.detail'), label: 'プロフィール', icon: <User size={20} /> },
  ];

  return (
    <nav className="fixed bottom-0 left-0 right-0 bg-white border-t shadow sm:hidden z-50">
      <div className="flex justify-around">
        {navItems.map((item) => (
          <Link
            key={item.label}
            href={item.href}
            className={`flex flex-col items-center justify-center flex-1 py-2 text-xs ${
              isActive(new URL(item.href).pathname) ? 'text-indigo-600' : 'text-gray-500'
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
