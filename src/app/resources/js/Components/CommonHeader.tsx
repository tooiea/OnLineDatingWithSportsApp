import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';

interface Props {
  routes: {
    current: string;
    home: string;
    my_profile: string;
    myteam_index: string;
    team_list: string;
    myteam_detail: string;
    logout: string;
    login: string;
  };
}

export default function CommonHeader({ routes }: Props) {
  const user = usePage().props.user as {
    name?: string;
    email?: string;
    image_path?: string;
    team?: { name: string };
  } || null;

  const [dropdownOpen, setDropdownOpen] = useState(false);
  const isActive = (routeName: keyof NonNullable<typeof routes>) => {
    return routes?.current === routes?.[routeName];
  };

  return (
    <nav className="bg-white border-b border-gray-200 fixed top-0 w-full z-50 shadow">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between h-16 items-center">
          <div className="flex items-center">
            <Link href={routes?.my_profile || '/'} className="flex items-center gap-2">
              <img
                src={user?.image_path ?? '/images/logo.png'}
                alt="プロフィール"
                className="w-8 h-8 rounded-full border"
              />
              {user?.name && (
                <span className="sm:inline text-sm text-gray-700 font-medium">
                  {user.name}
                </span>
              )}
            </Link>
          </div>
          <div className="hidden sm:flex items-center gap-6">
            {user ? (
              <>
                <NavLink href={routes.home} active={isActive('home')}>ホーム</NavLink>
                <NavLink href={routes.myteam_index} active={isActive('myteam_index')}>招待情報</NavLink>
                <NavLink href={routes.team_list} active={isActive('team_list')}>検索</NavLink>
                <NavLink href={routes.myteam_detail} active={isActive('myteam_detail')}>チーム情報</NavLink>
                <NavLink href={routes.my_profile} active={isActive('my_profile')}>プロフィール</NavLink>
                <NavLink href={routes.logout} method="post" as="button" active={false}>ログアウト</NavLink>
              </>
            ) : (
              <>
                <NavLink href={routes.login} active={isActive('login')}>ログイン</NavLink>
              </>
            )}
          </div>
          <div className="flex items-center gap-2 sm:hidden">
            <button
              onClick={() => setDropdownOpen(prev => !prev)}
              className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none"
            >
              <svg className="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path className={!dropdownOpen ? 'inline-flex' : 'hidden'} strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16" />
                <path className={dropdownOpen ? 'inline-flex' : 'hidden'} strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <div className={`absolute top-16 w-full bg-white shadow-md z-50 transition-opacity duration-300 ease-in-out ${dropdownOpen ? 'block' : 'hidden'} sm:hidden`}>
        <div className="pt-2 pb-3 space-y-1">
          {user ? (
            <>
              <ResponsiveNavLink href={routes.home} active={isActive('home')}>ホーム</ResponsiveNavLink>
              <ResponsiveNavLink href={routes.myteam_index} active={isActive('myteam_index')}>Myチームトップ</ResponsiveNavLink>
              <ResponsiveNavLink href={routes.team_list} active={isActive('team_list')}>チーム検索画面</ResponsiveNavLink>
              <ResponsiveNavLink href={routes.myteam_detail} active={isActive('myteam_detail')}>チームプロフィール</ResponsiveNavLink>
              <ResponsiveNavLink href={routes.my_profile} active={isActive('my_profile')}>マイプロフィール</ResponsiveNavLink>
              <ResponsiveNavLink href={routes.logout} method="post" as="button">ログアウト</ResponsiveNavLink>
            </>
          ) : (
            <>
              <ResponsiveNavLink href={routes.login} active={isActive('login')}>ログイン</ResponsiveNavLink>
            </>
          )}
        </div>
      </div>
    </nav>
  );
}
