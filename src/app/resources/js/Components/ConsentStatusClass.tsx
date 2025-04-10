const ConsentStatusClass = (status: number): string => {
  switch (status) {
    case 0:
      return 'bg-red-100 text-red-800 border border-yellow-400';
    case 1:
      return 'bg-green-100 text-green-800 border border-green-400';
    case 2:
      return 'bg-gray-100 text-gray-800 border border-gray-400';
    default:
      return 'bg-gray-100 text-gray-700';
  }
};

export default ConsentStatusClass;
