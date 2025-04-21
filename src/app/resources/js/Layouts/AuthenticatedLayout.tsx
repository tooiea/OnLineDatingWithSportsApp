import { PropsWithChildren, ReactNode, useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import MobileFooterNav from '@/Components/MobileFooterNav';

const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

export default function AuthenticatedLayout({
  header,
  children,
}: PropsWithChildren<{ header?: ReactNode }>) {
  const { url, component } = usePage();
  const user = usePage().props.auth.user as {
    name: string;
    email: string;
    image_path?: string;
    team?: { name: string };
  };

  const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);

  const isActive = (routeName: string) => route().current(routeName);

  return (
    <div className="min-h-screen bg-gray-100">
      <nav className="bg-white border-b border-gray-200 fixed top-0 w-full z-50 shadow">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between h-16 items-center">
            <div className="flex items-center">
              <Link href={route('my-profile.detail')} className="flex items-center gap-2">
                <img
                  src={user.image_path ?? '/images/logo.png'}
                  alt="プロフィール"
                  className="w-8 h-8 rounded-full border"
                />
                <span className="hidden sm:inline text-sm text-gray-700 font-medium">
                  {user.name}{user.team?.name && `：${user.team.name}`}
                </span>
              </Link>
            </div>
            <div className="hidden sm:flex items-center gap-6">
              <NavLink href="" active={isActive('dashboard')}>ホーム</NavLink>
              <NavLink href={route('myteam.index')} active={isActive('myteam.index')}>招待情報</NavLink>
              <NavLink href={route('team.list')} active={isActive('team.list')}>検索</NavLink>
              <NavLink href={route('myteam.detail')} active={isActive('myteam.detail')}>チーム情報</NavLink>
              <NavLink href={route('my-profile.detail')} active={isActive('my-profile.detail')}>プロフィール</NavLink>
              <NavLink href={route('logout')} method="post" as="button" active={false}>ログアウト</NavLink>
            </div>
            <div className="flex items-center gap-2 sm:hidden">
              <button
                onClick={() => setShowingNavigationDropdown(prev => !prev)}
                className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none"
              >
                <svg className="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                  <path className={!showingNavigationDropdown ? 'inline-flex' : 'hidden'} strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16" />
                  <path className={showingNavigationDropdown ? 'inline-flex' : 'hidden'} strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          {user.team?.name && (
            <div className="text-sm text-gray-700 text-center mt-1 sm:hidden">
              {user.name}：{user.team.name}
            </div>
          )}
        </div>

        <div className={`absolute top-16 w-full bg-white shadow-md z-50 transition-opacity duration-300 ease-in-out ${showingNavigationDropdown ? 'block' : 'hidden'} sm:hidden`}>
          <div className="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink href="" active={isActive('dashboard')}>ホーム</ResponsiveNavLink>
            <ResponsiveNavLink href={route('myteam.index')} active={isActive('myteam.index')}>Myチームトップ</ResponsiveNavLink>
            <ResponsiveNavLink href={route('team.list')} active={isActive('team.list')}>チーム検索画面</ResponsiveNavLink>
            <ResponsiveNavLink href={route('myteam.detail')} active={isActive('myteam.detail')}>チームプロフィール</ResponsiveNavLink>
            <ResponsiveNavLink href={route('my-profile.detail')} active={isActive('my-profile.detail')}>マイプロフィール</ResponsiveNavLink>
            <ResponsiveNavLink href={route('logout')} method="post" as="button">ログアウト</ResponsiveNavLink>
          </div>
        </div>
      </nav>

      <main className="pt-20 pb-20 px-4 sm:px-0">{children}</main>

      {isMobile && <MobileFooterNav />}
    </div>
  );
}
