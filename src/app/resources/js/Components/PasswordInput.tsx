import { Eye, EyeOff } from 'lucide-react';
import { useState } from 'react';

interface PasswordInputProps {
  name: string;
  value: string;
  onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
  placeholder?: string;
}

export default function PasswordInput({
  name,
  value,
  onChange,
  placeholder,
}: PasswordInputProps) {
  const [showPassword, setShowPassword] = useState(false);

  return (
    <div className="relative">
      <input
        type={showPassword ? 'text' : 'password'}
        name={name}
        value={value}
        onChange={onChange}
        placeholder={placeholder}
        className="w-full border-gray-300 rounded-md shadow-sm pr-10"
      />
      <button
        type="button"
        onClick={() => setShowPassword(prev => !prev)}
        className="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
        tabIndex={-1}
        aria-label="パスワード表示切替"
      >
        {showPassword ? <EyeOff size={20} /> : <Eye size={20} />}
      </button>
    </div>
  );
}
