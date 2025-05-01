import { Home, Search, Users, User, Contact } from 'lucide-react';
import { Link, usePage } from '@inertiajs/react';

export default function MobileFooterNav() {
  const routes = usePage().props.nav_routes as {
    current: string;
    home: string;
    my_profile: string;
    myteam_index: string;
    team_list: string;
    myteam_detail: string;
    logout : string;
  }

  const isActive = (routeName: keyof typeof routes) => {
    return routes.current === routes[routeName];
  };

  const navItems: { href: string; label: string; icon: JSX.Element; routeKey: keyof typeof routes }[] = [
    { href: routes.home, label: 'ホーム', icon: <Home size={20} />, routeKey: 'home' },
    { href: routes.myteam_index, label: '招待情報', icon: <Contact size={20} />, routeKey: 'myteam_index' },
    { href: routes.team_list, label: '検索', icon: <Search size={20} />, routeKey: 'team_list' },
    { href: routes.myteam_detail, label: 'チーム情報', icon: <Users size={20} />, routeKey: 'myteam_detail' },
    { href: routes.my_profile, label: 'プロフィール', icon: <User size={20} />, routeKey: 'my_profile' },
  ];

  return (
    <nav className="fixed bottom-0 left-0 right-0 bg-white border-t shadow sm:hidden z-50">
      <div className="flex justify-around">
        {navItems.map((item) => (
          <Link
            key={item.label}
            href={item.href}
            className={`flex flex-col items-center justify-center flex-1 py-2 text-xs ${
              isActive(item.routeKey) ? 'text-indigo-600' : 'text-gray-500'
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
