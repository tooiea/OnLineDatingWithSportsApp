import AuthenticatedFooterNav from './MobileFooterNav';
import GuestFooterNav from './GuestFooterNav';

interface Props {
  isAuthenticated: boolean;
  routes: {
    current: string;
    my_profile: string;
    myteam_index: string;
    team_list: string;
    myteam_detail: string;
    logout: string;
    login: string;
    home: string;
  };
}

export default function FooterNav({routes, isAuthenticated}: Props) {
  return isAuthenticated ? <AuthenticatedFooterNav routes={routes} /> : <GuestFooterNav routes={routes} />;
}
